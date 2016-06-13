<?

  namespace Funivan\Cs\Util;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\PhpTokenizer\Collection;

  /**
   *
   */
  trait FunivanTokenizer {

    private $collections = [];


    /**
     * @param FileInfo $fileInfo
     * @return Collection
     */
    public function getCollection(FileInfo $fileInfo) {
      $key = $fileInfo->getPath();
      if (!isset($this->collections[$key])) {
        $this->collections[$key] = \Funivan\PhpTokenizer\Collection::createFromString($fileInfo->getContent()->get());
      }

      return $this->collections[$key];
    }

  }