<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\Fs\FilesCollection;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class ReviewFileProcessor extends BaseFileProcessor {


    /**
     * @param FilesCollection $files
     * @param Report $report
     */
    public function process(FilesCollection $files, Report $report) {

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


          $this->getOutput()->writeln('✘ error : ' . $tool->getDescription() . ' (' . $tool->getName() . ')');
        }
      }

    }

  }