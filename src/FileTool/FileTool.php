<?php

  namespace Funivan\Cs\FileTool;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface FileTool {

    /**
     * Return unique string of the tool
     * You can set any name but we suggest to use following rules:
     *  - Allowed chars [a-z0-9_]+
     *  - Review tools should have ending `_review`
     *  - Fixer tools should have ending `_fixer`
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getDescription();


    /**
     * Check if we can process file by this tool
     * Called before file process
     *
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file);


    /**
     * @param File $file
     * @param Report $report
     */
    public function process(File $file, Report $report);


  }