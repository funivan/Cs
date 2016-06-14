<?php

  namespace Funivan\Cs\Report;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\FileTool\FileTool;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class Report implements \IteratorAggregate, \Countable {

    /**
     * @var Message[]
     */
    private $messages = [];




    /**
     * @param File $file
     * @param FileTool $tool
     * @param string $message
     * @param int|null $line
     * @return $this
     */
    public function addMessage(File $file, FileTool $tool, $message, $line = null) {
      $this->messages[] = new Message($file, $tool, $message, $line);
      return $this;
    }


    /**
     * @return Message[]
     */
    public function getIterator() {
      return new \ArrayIterator($this->messages);
    }


    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count() {
      return count($this->messages);
    }

  }