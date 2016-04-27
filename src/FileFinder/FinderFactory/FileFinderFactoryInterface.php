<?php

  namespace Funivan\Cs\FileFinder\FinderFactory;

  use Funivan\Cs\FileFinder\FileFinderInterface;
  use Funivan\Cs\FileFinder\FinderParams;


  /**
   *
   */
  interface FileFinderFactoryInterface {

    /**
     * @param FinderParams $finderParams
     * @return FileFinderInterface
     */
    public function createFileFinder(FinderParams $finderParams);

  }