<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\FileFinder\FileFinderInterface;
  use Funivan\Cs\Fs\FileFinder\FinderParameters;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface ConfigurationInterface {

    /**
     * @param FinderParameters $finderParams
     * @return FileFinderInterface
     */
    public function getFilesFinder();


    /**
     * @return FileTool[]
     */
    public function getTools();

  }