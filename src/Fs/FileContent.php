<?php

  namespace Funivan\Cs\Fs;

  /**
   *
   */
  class FileContent {

    /**
     * @var string
     */
    private $content;


    /**
     * @var string|null
     */
    private $initialContentHashSum = null;


    /**
     * @param string $content
     */
    public function __construct($content) {
      $this->content = $content;
      $this->initialContentHashSum = $this->getContentHash();
    }


    /**
     * @param string $content
     * @void
     */
    public function set($content) {
      $this->content = $content;
    }


    /**
     * @return string
     */
    public function get() {
      return $this->content;
    }


    /**
     * @return boolean
     */
    public function isChanged() {
      return ($this->initialContentHashSum !== $this->getContentHash());
    }


    /**
     * @return string
     */
    private function getContentHash() {
      return md5($this->content);
    }

  }