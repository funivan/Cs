<?php

  namespace Funivan\Cs\FileFinder;

  use Symfony\Component\Finder\Finder;
  use Symfony\Component\Finder\SplFileInfo;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class CustomFileFinder implements FileFinderInterface {

    /**
     * @var Finder
     */
    private $finder;


    /**
     * @param Finder $finder
     */
    public function __construct(Finder $finder) {
      $this->finder = $finder;
    }


    /**
     * @return FileInfoCollection
     */
    public function getFileCollection() {
      $filesCollection = new FileInfoCollection();

      $files = $this->finder->files();
      /** @var SplFileInfo $file */
      foreach ($files as $file) {
        $filesCollection[] = new File($file->getRealPath(), File::STATUS_UNKNOWN);
      }

      return $filesCollection;
    }

  }