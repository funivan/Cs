<?php

  namespace Funivan\Cs\FileFinder;

  use Symfony\Component\Process\Process;

  /**

   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class GitFileFinder implements FileFinderInterface {

    /**
     * @var string
     */
    private $directory;

    /**
     * @var null|string
     */
    private $commit = null;


    /**
     * By default we will check all uncommitted files
     *
     * @param string $directory
     * @param string|null $commit
     */
    public function __construct($directory, $commit = null) {
      $this->directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
      $this->commit = $commit;
    }


    /**
     * @return FileInfoCollection
     */
    public function getFileCollection() {

      if (!empty($this->commit)) {
        $process = new Process('git diff-tree --no-commit-id --name-status  -r ' . $this->commit);
      } else {
        $process = new Process('git diff --name-status ; git diff --cached --name-status');
      }

      $filesCollection = new FileInfoCollection();
      $process->run();
      if (!$process->isSuccessful()) {
        return $filesCollection;
      }

      $baseDir = $this->directory;

      $filesList = array_filter(explode("\n", $process->getOutput()));

      $statusMap = [
        'A' => File::STATUS_ADDED,
        'C' => File::STATUS_COPIED,
        'M' => File::STATUS_MODIFIED,
        'R' => File::STATUS_RENAMED,
        'D' => File::STATUS_DELETED,
      ];

      foreach ($filesList as $fileInfo) {

        preg_match('!^([^\s]+)\s+(.+)$!', $fileInfo, $matchedFileInfo);
        if (empty($matchedFileInfo[2])) {
          continue;
        }
        $gitStatus = trim($matchedFileInfo[1]);

        $status = !empty($statusMap[$gitStatus]) ? $statusMap[$gitStatus] : File::STATUS_UNKNOWN;

        $fullPath = $baseDir . ltrim($matchedFileInfo[2], DIRECTORY_SEPARATOR);
        $file = new File($fullPath, $status);
        $filesCollection[] = $file;
      }

      return $filesCollection;
    }

  }