<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileFinder\FinderFactory\FileFinderFactoryInterface;
  use Funivan\Cs\FileFinder\FinderParams;

  /**
   *
   */
  class CsConfiguration implements ConfigurationInterface {

    /**
     * @var FileFinderFactoryInterface|null
     */
    private $fileFinderFactory = null;

    /**
     * @var ToolConfigurationInterface[]
     */
    private $toolsConfiguration = [];


    /**
     * @return CsConfiguration
     */
    public static function createFixerConfiguration() {
      return (new CsConfiguration())->addToolsConfigurations(DefaultTools::getFixers());
    }


    /**
     * @return CsConfiguration
     */
    public static function createReviewConfiguration() {
      return (new CsConfiguration())->addToolsConfigurations(DefaultTools::getReviews());
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
     * @return ToolConfigurationInterface[]
     */
    public function getToolsConfiguration() {
      return $this->toolsConfiguration;
    }


    /**
     * @param ToolConfigurationInterface[] $toolsConfigurations
     * @return $this
     */
    public function addToolsConfigurations(array $toolsConfigurations) {
      foreach ($toolsConfigurations as $toolConfig) {
        $this->addToolConfiguration($toolConfig);
      }
      return $this;
    }


    /**
     * @param ToolConfigurationInterface $toolConfiguration
     * @return $this
     */
    public function addToolConfiguration(ToolConfigurationInterface $toolConfiguration) {
      $name = $toolConfiguration->getName();
      if (isset($this->toolsConfiguration[$name])) {
        throw new \InvalidArgumentException('Tool with name: ' . $name . ' already exist');
      }

      $this->toolsConfiguration[$name] = $toolConfiguration;
      return $this;
    }


    /**
     * @param string $name
     * @return ToolConfigurationInterface|null
     */
    public function getToolConfiguration($name) {
      if (isset($this->toolsConfiguration[$name])) {
        return $this->toolsConfiguration[$name];
      }
      return null;
    }

  }