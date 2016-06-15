<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\FileFinder\FileFinderInterface;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface ConfigurationInterface {

    /**
     * @return FileFinderInterface
     */
    public function getFilesFinder();


    /**
     * @return FileTool[]
     */
    public function getTools();

  }