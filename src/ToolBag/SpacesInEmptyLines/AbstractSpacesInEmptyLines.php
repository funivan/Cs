<?php

  namespace Funivan\Cs\ToolBag\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Query\Query;

  /**
   *
   */
  abstract class AbstractSpacesInEmptyLines implements FileTool {

    /**
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file) {
      return ($file->getStatus() !== FileInfo::STATUS_DELETED and in_array($file->getExtension(), ['php', 'html']));
    }


    /**
     * @param FileInfo $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function findTokens(FileInfo $file) {
      $tokens = $file->getTokenizer()->getCollection();

      $query = new Query();
      $query->valueLike('!\n([ ]+)\n!');
      $query->typeIs(T_WHITESPACE);

      $stripTokens = $tokens->find($query);

      return $stripTokens;
    }

  }
