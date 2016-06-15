<?php

  namespace Funivan\Cs\Fs;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FilesCollection implements \IteratorAggregate, \Countable {

    /**
     * @var File[]
     */
    private $files = [];


    /**
     * @param File $file
     */
    public function add(File $file) {
      $this->files[] = $file;
    }


    /**
     * @return File[]
     */
    public function getIterator() {
      return new \ArrayIterator($this->files);
    }


    /**
     * @return int
     */
    public function count() {
      return count($this->files);
    }

  }