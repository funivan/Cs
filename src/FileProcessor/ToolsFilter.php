<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\Configuration\ToolConfigurationInterface;

  /**
   * @todo move class to other namespace
   */
  class ToolsFilter {

    /**
     * @var ToolConfigurationInterface[]
     */
    private $tools = [];


    /**
     * @param ToolConfigurationInterface[] $tools
     */
    public function __construct(array $tools) {
      $this->tools = $tools;
    }


    /**
     * @param array $toolNames
     * @return ToolConfigurationInterface[]
     */
    public function filterTools(array $toolNames) {
      if (empty($toolNames)) {
        return $this->tools;
      }

      $include = null;
      $exclude = null;

      /** @var ToolConfigurationInterface[] $toolNames */
      foreach ($toolNames as $name) {
        if (preg_match('!^-[a-z0-9]+!', $name)) {
          $exclude[] = substr($name, 1);
        } else {
          $include[] = $name;
        }
      }

      $tools = [];
      foreach ($this->tools as $tool) {
        $toolName = $tool->getName();
        $add = true;

        if (null !== $include) {
          $add = in_array($toolName, $include);
        }

        if (null !== $exclude) {
          $add = !in_array($toolName, $exclude);
        }

        if ($add === false) {
          continue;
        }

        $tools[$toolName] = $tool;
      }

      return $tools;
    }

  }