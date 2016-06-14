<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileFinder\FileFinderInterface;
  use Funivan\Cs\FileFinder\FinderParams;
  use Funivan\Cs\FileTool\FileTool;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface ConfigurationInterface {

    /**
     * @param FinderParams $finderParams
     * @return FileFinderInterface
     */
    public function getFileFinderFactory(FinderParams $finderParams);


    /**
     * @return FileTool[]
     */
    public function getTools();

  }