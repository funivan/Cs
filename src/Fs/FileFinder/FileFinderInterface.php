<?php

  namespace Funivan\Cs\Fs\FileFinder;

  use Funivan\Cs\Fs\FilesCollection;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  interface FileFinderInterface {

    /**
     * @param FinderParameters $finderParameters
     * @return FilesCollection
     */
    public function findFiles(FinderParameters $finderParameters);

  }