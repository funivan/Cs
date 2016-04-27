<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileFinder\FileFinderInterface;
  use Funivan\Cs\FileFinder\FinderParams;

  /**
   *
   */
  interface ConfigurationInterface {

    /**
     * @param FinderParams $finderParams
     * @return FileFinderInterface
     */
    public function getFileFinderFactory(FinderParams $finderParams);


    /**
     * @return ToolConfigurationInterface[]
     */
    public function getToolsConfiguration();

  }