<?php

  namespace Funivan\Cs\FileFinder\FinderFactory;

  use Funivan\Cs\FileFinder\CustomFileFinder;
  use Funivan\Cs\FileFinder\FileFinderInterface;
  use Funivan\Cs\FileFinder\FinderParams;
  use Funivan\Cs\FileFinder\GitFileFinder;
  use Symfony\Component\Finder\Finder;

  /**
   *
   */
  class FileFinderFactory implements FileFinderFactoryInterface {

    /**
     * @var null
     */
    private $baseDir = null;


    /**
     * @param string $baseDir
     */
    public function __construct($baseDir) {
      $this->baseDir = $baseDir;
    }


    /**
     * @return string
     */
    public function getBaseDir() {
      return $this->baseDir;
    }


    /**
     * @param FinderParams $finderParams
     * @return FileFinderInterface
     */
    public function createFileFinder(FinderParams $finderParams) {

      if ($finderParams->getDirectory()) {
        return new CustomFileFinder((new Finder())->in($finderParams->getDirectory()));
      }

      $gitRepo = $this->getBaseDir();

      return new GitFileFinder($gitRepo, $finderParams->getCommit());
    }

  }