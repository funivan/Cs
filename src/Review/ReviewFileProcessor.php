<?php

  namespace Funivan\Cs\Review;

  use Funivan\Cs\FileFinder\FileInfoCollection;
  use Funivan\Cs\FileProcessor\BaseFileProcessor;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class ReviewFileProcessor extends BaseFileProcessor {


    /**
     * @param FileInfoCollection $files
     * @param Report $report
     */
    public function process(FileInfoCollection $files, Report $report) {

      $isDebug = $this->getOutput()->isDebug();

      foreach ($files as $file) {
        $errorsNum = $report->count();

        if ($isDebug) {
          $this->getOutput()->writeln('⚑ open  : ' . $file->getPath());
        }

        foreach ($this->getTools() as $tool) {


          if (!$tool->canProcess($file)) {
            continue;
          }

          $tool->process($file, $report);
          if ($errorsNum === $report->count()) {
            if ($isDebug) {

              $this->getOutput()->writeln('✔ ok    : ' . $tool->getDescription() . ' (' . $tool->getName() . ')');
            }
            continue;
          }


          $this->getOutput()->writeln('✘ error : ' . $tool->getDescription(). ' (' . $tool->getName() . ')');
        }
      }

    }

  }