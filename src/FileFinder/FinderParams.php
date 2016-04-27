<?php

  namespace Funivan\Cs\FileFinder;

  /**
   *
   */
  class FinderParams {

    /**
     * @var string|null
     */
    private $directory = null;

    /**
     * @var string|null
     */
    private $commit = null;


    /**
     * @return string
     */
    public function getDirectory() {
      return $this->directory;
    }


    /**
     * @param string $directory
     * @return $this
     */
    public function setDirectory($directory) {
      $this->directory = $directory;
      return $this;
    }


    /**
     * @return null|string
     */
    public function getCommit() {
      return $this->commit;
    }


    /**
     * @param null|string $commit
     * @return $this
     */
    public function setCommit($commit) {
      $this->commit = $commit;
      return $this;
    }

  }