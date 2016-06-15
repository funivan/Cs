<?php

  namespace Funivan\Cs\Report;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class Message {

    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $text;


    /**
     * @var FileTool
     */
    private $tool;

    /**
     * @var int|null
     */
    private $line;


    /**
     * @param File $file
     * @param FileTool $tool
     * @param $text
     * @param int|null $line
     */
    public function __construct(File $file, FileTool $tool, $text, $line) {

      $this->file = $file;
      $this->text = $text;
      $this->tool = $tool;
      $this->line = $line;
    }


    /**
     * @return string
     */
    public function getText() {
      return $this->text;
    }


    /**
     * @return File
     */
    public function getFile() {
      return $this->file;
    }


    /**
     * @return int|null
     */
    public function getLine() {
      return $this->line;
    }


    /**
     * @return FileTool
     */
    public function getTool() {
      return $this->tool;
    }

  }