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
     * @var array
     */
    private $toolsConfiguration = [];


    /**
     * @return CsConfiguration
     */
    public static function createFixerConfiguration() {
      return self::createWithTools(DefaultTools::getFixTools());
    }


    /**
     * @return CsConfiguration
     */
    public static function createReviewConfiguration() {
      return self::createWithTools(DefaultTools::getReviewTools());
    }


    /**
     * @param array $tools
     * @return CsConfiguration
     */
    private static function createWithTools($tools) {
      $configuration = new CsConfiguration();
      foreach ($tools as $name => $class) {
        $configuration->addToolConfiguration(
          new ToolConfiguration($name, $class)
        );
      }

      return $configuration;
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

  }