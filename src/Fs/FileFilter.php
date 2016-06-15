<?php

  namespace Funivan\Cs\Fs;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FileFilter {

    /**
     * @var callable[]
     */
    private $callback = [];


    /**
     * @param string $type
     * @return $this
     */
    public function mimeType($type) {
      $this->callback[] = function (File $file) use ($type) {
        return (strpos($file->getMimeType(), $type) === 0);
      };
      return $this;
    }


    /**
     * @param string|array $regex
     * @return $this
     */
    public function path($regex) {
      $this->callback[] = function (File $file) use ($regex) {
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
     * @param string[] $regex
     * @return $this
     */
    public function name(array $regex) {
      $this->callback[] = function (File $file) use ($regex) {
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
     * @param string[] $ext
     * @return $this
     */
    public function extension(array $ext) {
      $this->callback[] = function (File $file) use ($ext) {
        return (in_array($file->getExtension(), $ext));
      };
      return $this;
    }


    /**
     * @param array|string $status
     * @return $this
     */
    public function status($status) {
      $this->callback[] = function (File $file) use ($status) {
        $status = (array) $status;
        return in_array($file->getStatus(), $status);
      };
    }


    /**
     * @return $this
     */
    public function notDeleted() {
      $this->status([
        File::STATUS_ADDED,
        File::STATUS_COPIED,
        File::STATUS_RENAMED,
        File::STATUS_MODIFIED,
        File::STATUS_UNKNOWN,
      ]);
      return $this;
    }


    /**
     * @param File $fileInfo
     * @return bool
     */
    public function isValid(File $fileInfo) {

      foreach ($this->callback as $callback) {
        if ($callback($fileInfo) === false) {
          return false;
        }
      }

      return true;
    }

  }