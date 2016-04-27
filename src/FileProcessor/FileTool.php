<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface FileTool {

    /**
     * Return unique string of the tool
     * Review tools should have ending `_review`
     * Fixer tools should have ending `_fixer`
     *
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getDescription();


    /**
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file);


    /**
     * @param FileInfo $file
     * @param Report $report
     */
    public function process(FileInfo $file, Report $report);


  }