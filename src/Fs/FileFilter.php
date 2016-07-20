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
     * @param string[] $regex
     * @return $this
     */
    public function mimeType($regex) {
      $this->callback[] = function (File $file) use ($regex) {
        return $this->processMatch($regex, $file->getMimeType());
      };
      return $this;
    }


    /**
     * @param string[] $regex
     * @return $this
     */
    public function path(array $regex) {
      $this->callback[] = function (File $file) use ($regex) {
        return $this->processMatch($regex, $file->getPath());
      };

      return $this;
    }


    /**
     * @param string[] $regex
     * @return $this
     */
    public function name(array $regex) {
      $this->callback[] = function (File $file) use ($regex) {
        return $this->processMatch($regex, $file->getName());
      };
      return $this;
    }


    /**
     * @param string[] $ext
     * @return $this
     */
    public function extension(array $ext) {
      $this->callback[] = function (File $file) use ($ext) {
        return in_array($file->getExtension(), $ext);
      };
      return $this;
    }


    /**
     * @param int[] $status
     * @return $this
     */
    public function status(array $status) {
      $this->callback[] = function (File $file) use ($status) {
        return in_array($file->getStatus(), $status);
      };
      return $this;
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


    /**
     * @param string[] $regex
     * @param string $value
     * @return bool
     */
    private function processMatch(array $regex, $value) {
      foreach ($regex as $reg) {
        if (preg_match($reg, $value) === 1) {
          return true;
        }
      }
      return false;
    }

  }