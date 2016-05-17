<?php

  namespace Funivan\Cs\Review\Tools;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Message\Report;
  use Symfony\Component\Process\Process;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class ComposerReview implements FileTool {

    const NAME = 'composer_review';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @inheritdoc
     */
    public function getDescription() {
      return 'Validate composer.json file';
    }


    /**
     * @inheritdoc
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->name('!^composer.json$')->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {

      $cmd = sprintf('composer validate %s', $file->getPath());

      $process = new Process($cmd);
      $process->run();

      if ($process->isSuccessful()) {
        return;
      }


      $errorOutput = $process->getErrorOutput();
      preg_match('!Parse error on line (\d+):!', $errorOutput, $matchedLine);
      $line = 0;
      if (isset($matchedLine[1])) {
        $line = (int) $matchedLine[1];
      }

      $report->addError($file, $this, 'Invalid composer.json file format', $line);
    }

  }