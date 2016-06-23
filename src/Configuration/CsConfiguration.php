<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\FileFinder\FileFinderInterface;
  use Funivan\Cs\Fs\FileFinder\StandardFileFinder;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class CsConfiguration implements ConfigurationInterface {

    /**
     * @var FileFinderInterface
     */
    private $fileFinder;

    /**
     * @var FileTool[]
     */
    private $tools = [];


    /**
     * @param FileFinderInterface $fileFinder
     */
    public function __construct(FileFinderInterface $fileFinder) {
      $this->fileFinder = $fileFinder;
    }


    /**
     * @return CsConfiguration
     */
    public static function createFixerConfiguration() {
      return (new CsConfiguration(new StandardFileFinder()))->addTools(DefaultTools::getFixers());
    }


    /**
     * @return CsConfiguration
     */
    public static function createReviewConfiguration() {
      return (new CsConfiguration(new StandardFileFinder()))->addTools(DefaultTools::getReviews());
    }


    /**
     * @inheritdoc
     */
    public function getFilesFinder() {
      return $this->fileFinder;
    }


    /**
     * @param FileFinderInterface $fileFinder
     * @return $this
     */
    public function setFileFinder(FileFinderInterface $fileFinder) {
      $this->fileFinder = $fileFinder;
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
     * @param FileTool $fileTool
     * @return $this
     */
    public function removeTool(FileTool $fileTool) {
      $name = $fileTool->getName();
      unset($this->tools[$name]);
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