<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class CustomFileTool implements FileTool {

    /**
     * @var string
     */
    private $id;

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
     * @param string $id
     */
    public function __construct($id) {
      $this->id = $id;
    }


    /**
     * @inheritdoc
     */
    public function getName() {
      return $this->id;
    }


    /**
     * @return string
     */
    public function getDescription() {
      if ($this->description === null) {
        throw new \RuntimeException('Empty description');

      }
      return $this->description;
    }


    /**
     * @param FileInfo $file
     * @return bool
     * @throws \Exception
     */
    public function canProcess(FileInfo $file) {
      $callback = $this->canProcessCallback;

      if ($callback === null) {
        throw new \Exception('Empty canProcess callback');
      }

      return $callback($file);
    }


    /**
     * @param FileInfo $file
     * @param Report $report
     * @throws \Exception
     */
    public function process(FileInfo $file, Report $report) {
      $callback = $this->processCallback;

      if ($callback === null) {
        throw new \Exception('Empty process callback');
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