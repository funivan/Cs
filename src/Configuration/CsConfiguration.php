<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileFinder\FinderFactory\FileFinderFactoryInterface;
  use Funivan\Cs\FileFinder\FinderParams;
  use Funivan\Cs\FileTool\FileTool;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class CsConfiguration implements ConfigurationInterface {

    /**
     * @var FileFinderFactoryInterface|null
     */
    private $fileFinderFactory = null;

    /**
     * @var FileTool[]
     */
    private $tools = [];


    /**
     * @return CsConfiguration
     */
    public static function createFixerConfiguration() {
      return (new CsConfiguration())->addTools(DefaultTools::getFixers());
    }


    /**
     * @return CsConfiguration
     */
    public static function createReviewConfiguration() {
      return (new CsConfiguration())->addTools(DefaultTools::getReviews());
    }


    /**
     * @inheritdoc
     */
    public function getFileFinderFactory(FinderParams $finderParams) {
      if ($this->fileFinderFactory === null) {
        throw new \Exception('Empty file finder factory');
      }

      return $this->fileFinderFactory->createFileFinder($finderParams);
    }


    /**
     * @param FileFinderFactoryInterface $fileFinder
     * @return $this
     */
    public function setFileFinderFactory(FileFinderFactoryInterface $fileFinder) {
      $this->fileFinderFactory = $fileFinder;
      return $this;
    }


    /**
     * @return FileTool[]
     */
    public function getTools() {
      return $this->tools;
    }


    /**
     * @param FileTool[] $fileTools
     * @return $this
     */
    public function addTools(array $fileTools) {
      foreach ($fileTools as $toolConfig) {
        $this->addTool($toolConfig);
      }
      return $this;
    }


    /**
     * @param FileTool $fileTool
     * @return $this
     */
    public function addTool(FileTool $fileTool) {
      $name = $fileTool->getName();
      if (isset($this->tools[$name])) {
        throw new \InvalidArgumentException('Tool with name: ' . $name . ' already exist');
      }

      $this->tools[$name] = $fileTool;
      return $this;
    }


    /**
     * @param FileTool $fileTool
     * @return $this
     */
    public function setTool(FileTool $fileTool) {
      $name = $fileTool->getName();
      $this->tools[$name] = $fileTool;
      return $this;
    }


    /**
     * @param string $name
     * @return FileTool|null
     */
    public function getTool($name) {
      if (isset($this->tools[$name])) {
        return $this->tools[$name];
      }

      return null;
    }

  }