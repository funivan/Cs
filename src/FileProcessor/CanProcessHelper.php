<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileFinder\FileInfo;

  /**
   * @todo rename
   */
  class CanProcessHelper {

    /**
     * @var callable[]
     */
    private $callback = [];


    /**
     * @param string $type
     * @return $this
     */
    public function mimeType($type) {
      $this->callback[] = function (FileInfo $file) use ($type) {
        return (strpos($file->getMimeType(), $type) === 0);
      };
      return $this;
    }


    /**
     * @param string|array $regex
     * @return $this
     */
    public function path($regex) {
      $this->callback[] = function (FileInfo $file) use ($regex) {
        $regex = (array) $regex;
        $path = $file->getPath();

        foreach ($regex as $reg) {
          if (preg_match($reg, $path)) {
            return true;
          }
        }
        return false;
      };

      return $this;
    }


    /**
     * @param string|array $regex
     * @return $this
     */
    public function name($regex) {
      $this->callback[] = function (FileInfo $file) use ($regex) {
        $regex = (array) $regex;
        $path = $file->getName();

        foreach ($regex as $reg) {
          if (preg_match($reg, $path)) {
            return true;
          }
        }
        return false;
      };
      return $this;
    }


    /**
     * @param array|string $ext
     * @return $this
     */
    public function extension($ext) {
      $this->callback[] = function (FileInfo $file) use ($ext) {
        return (in_array($file->getExtension(), (array) $ext));
      };
      return $this;
    }


    /**
     * @param array|string $status
     * @return $this
     */
    public function status($status) {
      $this->callback[] = function (FileInfo $file) use ($status) {
        $status = (array) $status;
        return in_array($file->getStatus(), $status);
      };
    }


    /**
     * @return $this
     */
    public function notDeleted() {
      $this->status([
        FileInfo::STATUS_ADDED,
        FileInfo::STATUS_COPIED,
        FileInfo::STATUS_RENAMED,
        FileInfo::STATUS_MODIFIED,
        FileInfo::STATUS_UNKNOWN,
      ]);
      return $this;
    }


    /**
     * @param FileInfo $fileInfo
     * @return bool
     */
    public function isValid(FileInfo $fileInfo) {

      foreach ($this->callback as $callback) {
        if ($callback($fileInfo) === false) {
          return false;
        }
      }

      return true;
    }

  }