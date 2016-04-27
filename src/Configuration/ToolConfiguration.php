<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  class ToolConfiguration implements ToolConfigurationInterface {

    /**
     * @var string
     */
    private $classFqn;

    /**
     * @var string
     */
    private $name;


    /**
     * @param $name
     * @param string $classFqn
     */
    public function __construct($name, $classFqn) {
      $this->classFqn = $classFqn;
      $this->name = $name;
    }


    /**
     * @return string
     */
    public function getName() {
      return $this->name;
    }


    /**
     * @return FileTool
     */
    public function createTool() {
      $className = $this->classFqn;
      return new $className();
    }

  }