<?php

  namespace Funivan\Cs\FileFinder\FinderFactory;

  use Funivan\Cs\FileFinder\CustomFileFinder;
  use Funivan\Cs\FileFinder\FileFinderInterface;
  use Funivan\Cs\FileFinder\FinderParams;
  use Symfony\Component\Finder\Finder;

  /**
   *
   */
  class DirectoryBasedFileFinderFactory implements FileFinderFactoryInterface {

    /**
     * @param FinderParams $finderParams
     * @return FileFinderInterface
     * @throws \Exception
     */
    public function createFileFinder(FinderParams $finderParams) {
      $directory = $finderParams->getDirectory();

      if (empty($directory)) {
        throw new \Exception('Expect valid file path');
      }

      return new CustomFileFinder((new Finder())->in($finderParams->getDirectory()));
    }

  }