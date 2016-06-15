<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\FilesCollection;
  use Funivan\Cs\Report\Report;


  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface FileProcessorInterface {

    /**
     * @param FileTool $tool
     * @return $this
     */
    public function addTool(FileTool $tool);


    /**
     * @param FilesCollection $files
     * @param Report $report
     */
    public function process(FilesCollection $files, Report $report);

  }