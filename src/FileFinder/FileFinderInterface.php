<?php

  namespace Funivan\Cs\FileFinder;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface FileFinderInterface {

    /**
     * @return FileInfoCollection
     */
    public function getFiles();

  }