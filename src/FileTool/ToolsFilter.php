<?php

  namespace Funivan\Cs\FileTool;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class ToolsFilter {

    /**
     * @var null|string[]
     */
    private $include;

    /**
     * @var null|string[]
     */
    private $exclude;


    /**
     * @param string[]|null $include
     * @param string[]|null $exclude
     */
    public function __construct(array $include = null, array $exclude = null) {
      $this->include = $include;
      $this->exclude = $exclude;
    }


    /**
     * @param string $filters
     * @param string $delimiter
     */
    public static function createFromString($filters, $delimiter = ',') {
      $include = null;
      $exclude = null;


      $fixerNames = explode($delimiter, $filters);
      $fixerNames = array_map('trim', $fixerNames);
      $fixerNames = array_filter($fixerNames);

      foreach ($fixerNames as $name) {
        if (strpos($name, '-') === 0) {
          $exclude[] = substr($name, 1);
        } else {
          $include[] = $name;
        }
      }

      return new self($include, $exclude);
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