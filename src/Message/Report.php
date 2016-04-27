<?php

  namespace Funivan\Cs\Message;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\FileTool;
  use Fiv\Collection\ObjectCollection;

  /**
   * @method FileMessage current()
   *
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class Report extends ObjectCollection {

    /**
     * @inheritdoc
     */
    public function objectsClassName() {
      return FileMessage::class;
    }


    /**
     * @param FileInfo $file
     * @param FileTool $tool
     * @param string $message
     * @param int|null $line
     * @return $this
     */
    public function addError(FileInfo $file, FileTool $tool, $message, $line = null) {
      $this[] = new FileMessage($file, $tool, $message, $line, FileMessage::LEVEL_ERROR);
      return $this;
    }


    /**
     * @param FileInfo $file
     * @param FileTool $tool
     * @param string $message
     * @param int|null $line
     * @return $this
     */
    public function addNotice(FileInfo $file, FileTool $tool, $message, $line = null) {
      $this[] = new FileMessage($file, $tool, $message, $line, FileMessage::LEVEL_NOTICE);
      return $this;
    }

  }