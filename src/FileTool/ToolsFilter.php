<?php

  namespace Funivan\Cs\FileTool;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class ToolsFilter {

    /**
     * @var null|string[]
     */
    private $include = null;

    /**
     * @var null|string[]
     */
    private $exclude = null;


    /**
     * @return null|string[]
     */
    public function getInclude() {
      return $this->include;
    }


    /**
     * @param null|string[] $include
     * @return $this
     */
    public function setInclude(array $include = null) {
      $this->include = $include;
    }


    /**
     * @return null|\string[]
     */
    public function getExclude() {
      return $this->exclude;
    }


    /**
     * @param null|\string[] $exclude
     * @return $this
     */
    public function setExclude(array $exclude = null) {
      $this->exclude = $exclude;
    }


    /**
     * @param FileTool $tool
     * @return bool
     */
    public function isValid(FileTool $tool) {

      $toolName = $tool->getName();

      if (null !== $this->exclude and in_array($toolName, $this->exclude)) {
        return false;
      }

      if (null !== $this->include and !in_array($toolName, $this->include)) {
        return false;
      }


      return true;
    }

  }