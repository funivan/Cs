<?php

  namespace Funivan\Cs\Fs\FileFinder;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FilesCollection;
  use Symfony\Component\Finder\Finder;
  use Symfony\Component\Finder\SplFileInfo;
  use Symfony\Component\Process\Process;

  /**
   *
   */
  class StandardFileFinder implements FileFinderInterface {

    /**
     * @param FinderParameters $finderParameters
     * @return FilesCollection
     * @internal param FinderParameters $params
     */
    public function findFiles(FinderParameters $finderParameters) {
      $filesCollection = new FilesCollection();

      if ($finderParameters->get('dir') !== null) {
        $dir = $finderParameters->get('dir');

        $files = (new Finder())->in($dir)->files();

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
          $filesCollection->add(new File($file->getRealPath(), File::STATUS_UNKNOWN));
        }

        return $filesCollection;
      }

      $baseDir = $finderParameters->get('baseDir');
      if ($baseDir == null) {
        throw new \RuntimeException('Can not find files. Invalid baseDir finder parameter.');
      }
      $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
      $commit = $finderParameters->get('commit');
      if ($commit !== null) {
        $process = new Process('git diff-tree --no-commit-id --name-status  -r ' . $commit);
      } else {
        $process = new Process('git diff --name-status ; git diff --cached --name-status');
      }


      $process->run();
      if (!$process->isSuccessful()) {
        return $filesCollection;
      }


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
        $filesCollection->add(new File($fullPath, $status));
      }

      return $filesCollection;

    }

  }