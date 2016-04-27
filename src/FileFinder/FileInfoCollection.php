<?php

  namespace Funivan\Cs\FileFinder;

  use Fiv\Collection\ObjectCollection;

  /**
   * @method FileInfo current()
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class FileInfoCollection extends ObjectCollection {

    /**
     * @inheritdoc
     */
    public function objectsClassName() {
      return FileInfo::class;
    }

  }