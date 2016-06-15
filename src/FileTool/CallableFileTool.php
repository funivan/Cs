<?php

  namespace Funivan\Cs\FileTool;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class CallableFileTool implements FileTool {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description = null;

    /**
     * @var callable|null
     */
    private $processCallback = null;

    /**
     * @var callable|null
     */
    private $canProcessCallback = null;


    /**
     * @param string $name
     */
    public function __construct($name) {
      $this->name = $name;
    }


    /**
     * @inheritdoc
     */
    public function getName() {
      return $this->name;
    }


    /**
     * @return string
     */
    public function getDescription() {
      if ($this->description === null) {
        throw new \RuntimeException('Empty tool description');

      }
      return $this->description;
    }


    /**
     * @param File $file
     * @return bool
     * @throws \Exception
     */
    public function canProcess(File $file) {
      $callback = $this->canProcessCallback;

      if ($callback === null) {
        throw new \RuntimeException('Empty canProcess callback');
      }

      return $callback($file);
    }


    /**
     * @param File $file
     * @param Report $report
     * @throws \Exception
     */
    public function process(File $file, Report $report) {
      $callback = $this->processCallback;

      if ($callback === null) {
        throw new \RuntimeException('Empty process callback');
      }


      $callback($file, $report);
    }


    /**
     * @param callable $processCallback
     * @return $this
     */
    public function setProcessCallback(callable  $processCallback) {
      $this->processCallback = $processCallback;
      return $this;
    }


    /**
     * @param callable $canProcessCallback
     * @return $this
     */
    public function setCanProcessCallback(callable $canProcessCallback) {
      $this->canProcessCallback = $canProcessCallback;
      return $this;
    }

  }