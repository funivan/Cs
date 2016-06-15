<?php

  namespace Funivan\Cs\Fs\FileFinder;

  /**
   *
   */
  class FinderParameters {

    /**
     * @var array
     */
    private $bag = [];


    /**
     * @param string $name
     * @param string $value
     */
    public function set($name, $value) {
      $this->bag[$name] = $value;
    }


    /**
     * @param string $name
     * @return string|null
     */
    public function get($name) {
      return isset($this->bag[$name]) ? $this->bag[$name] : null;
    }

  }