<?php

  namespace Funivan\Cs\FileFinder;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FileInfo {

    const STATUS_UNKNOWN = 0;

    const STATUS_ADDED = 1;

    const STATUS_COPIED = 2;

    const STATUS_MODIFIED = 3;

    const STATUS_RENAMED = 4;

    const STATUS_DELETED = 5;


    /**
     * @var array
     */
    private static $statusMap = [
      self::STATUS_UNKNOWN => 'unknown',
      self::STATUS_ADDED => 'added',
      self::STATUS_COPIED => 'copied',
      self::STATUS_MODIFIED => 'modified',
      self::STATUS_RENAMED => 'renamed',
      self::STATUS_DELETED => 'deleted',
    ];

    /**
     * The full path to the file
     *
     * @var string
     */
    private $path;

    /**
     * The files status
     *
     * @var int
     */
    private $status;

    /**
     * @var \Funivan\PhpTokenizer\File
     */
    private $tokenizer;


    /**
     * Initializes a new instance of the File class.
     *
     * @param string $status
     * @param string $filePath
     */
    public function __construct($filePath, $status) {
      if (!isset(self::$statusMap[$status])) {
        throw new \InvalidArgumentException('Invalid status');
      }

      $this->status = (int) $status;
      $this->path = $filePath;
    }


    /**
     * @return string
     */
    public function getName() {
      return basename($this->path);
    }


    /**
     * @return string
     */
    public function getExtension() {
      return pathinfo($this->path, PATHINFO_EXTENSION);
    }


    /**
     * @return string
     */
    public function getStatus() {
      return $this->status;
    }


    /**
     * @return string
     */
    public function getStatusName() {
      return self::$statusMap[$this->status];
    }


    /**
     * @return string
     */
    public function getMimeType() {
      if ($this->status === self::STATUS_DELETED) {
        return '';
      }
      return finfo_file(finfo_open(FILEINFO_MIME), $this->path);
    }


    /**
     * @return string
     */
    public function getPath() {
      return $this->path;
    }


    /**
     * @return \Funivan\PhpTokenizer\File
     */
    public function getTokenizer() {
      if (empty($this->tokenizer)) {
        $this->tokenizer = new \Funivan\PhpTokenizer\File($this->getPath());
      }

      return $this->tokenizer;
    }

  }
