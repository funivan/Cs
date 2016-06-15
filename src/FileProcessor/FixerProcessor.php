<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\Fs\FilesCollection;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FixerProcessor extends BaseFileProcessor {

    /**
     * @var bool
     */
    private $saveFiles = false;


    /**
     * @param FilesCollection $files
     * @param Report $report
     */
    public function process(FilesCollection $files, Report $report) {

      if (empty($this->getTools())) {
        $this->getOutput()->writeln('<comment>Empty tools list</comment>');
        return;
      }

      $message = '✘ dry run  ';
      if ($this->saveFiles) {
        $message = '✔ fixed    ';
      }

      foreach ($files as $file) {

        $fixed = false;

        foreach ($this->getTools() as $tool) {

          if ($this->getOutput()->isDebug()) {
            $this->getOutput()->writeln('process : (' . $tool->getName() . ') ' . $file->getPath());
          }

          if (!$tool->canProcess($file)) {
            continue;
          }

          $tool->process($file, $report);

          $fileChanged = $file->getContent()->isChanged();
          if ($fileChanged === false) {
            continue;
          }

          $fixed = true;

          $this->getOutput()->writeln('<info>' . $message . ': ' . $tool->getDescription() . '</info>');
        }

        if ($fixed and $this->saveFiles) {
          $file->save();
          $this->getOutput()->writeln('<info>' . '✔ saved    : ' . $file->getPath() . '</info>');
        }

      }

    }


    /**
     * @return boolean
     */
    public function getSaveFiles() {
      return $this->saveFiles;
    }


    /**
     * @param boolean $saveFiles
     */
    public function setSaveFiles($saveFiles) {
      $this->saveFiles = $saveFiles;
    }

  }