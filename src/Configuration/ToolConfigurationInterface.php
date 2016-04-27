<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  interface ToolConfigurationInterface {

    /**
     * @return string
     */
    public function getName();


    /**
     * @return FileTool
     */
    public function createTool();


  }