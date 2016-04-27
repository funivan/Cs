<?php

  namespace Funivan\Cs\Message;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\FileTool;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FileMessage {

    const LEVEL_NOTICE = 0;

    const LEVEL_ERROR = 1;

    /**
     * @var int
     */
    private $level;

    /**
     * @var FileInfo
     */
    private $file;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private static $levelMap = [
      self::LEVEL_NOTICE => 'notice',
      self::LEVEL_ERROR => 'error',
    ];

    /**
     * @var FileTool
     */
    private $tool;

    /**
     * @var int|null
     */
    private $line;


    /**
     * @param FileInfo $file
     * @param FileTool $tool
     * @param $text
     * @param int|null $line
     * @param int $level
     */
    public function __construct(FileInfo $file, FileTool $tool, $text, $line, $level = null) {

      $level = ($level !== null) ? $level : self::LEVEL_ERROR;

      if (!isset(self::$levelMap[$level])) {
        throw new \InvalidArgumentException('Invalid level');
      }

      $this->file = $file;
      $this->text = $text;
      $this->level = $level;
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
     * @return FileInfo
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
     * @return int
     */
    public function getLevel() {
      return $this->level;
    }


    /**
     * @return string
     */
    public function getLevelName() {
      return self::$levelMap[$this->level];
    }


    /**
     * @return FileTool
     */
    public function getTool() {
      return $this->tool;
    }


    /**
     * @return string
     */
    public function getToolName() {
      return ucfirst(str_replace('_', ' ', $this->getTool()->getName()));
    }

  }