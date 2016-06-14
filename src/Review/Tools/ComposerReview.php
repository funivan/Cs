<?php

  namespace Funivan\Cs\Review\Tools;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Filters\FileFilter;
  use Funivan\Cs\Report\Report;
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
    public function canProcess(File $file) {
      return (new FileFilter())->name('!^composer.json$!')->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(File $file, Report $report) {

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

      $report->addMessage($file, $this, 'Invalid composer.json file format', $line);
    }

  }