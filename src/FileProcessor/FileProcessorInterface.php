<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileFinder\FileInfoCollection;
  use Funivan\Cs\Message\Report;


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
     * @param FileInfoCollection $files
     * @param Report $report
     */
    public function process(FileInfoCollection $files, Report $report);

  }