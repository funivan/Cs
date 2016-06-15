<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Filters\FileFilter;
  use Funivan\Cs\Fs\File;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  abstract class AbstractSpacesInEmptyLines implements FileTool {

    /**
     * @codeCoverageIgnore
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file) {
      return (new FileFilter())->notDeleted()->extension(['php', 'html'])->isValid($file);
    }


    /**
     * @param Collection $collection
     * @return Collection
     */
    protected function findTokens(Collection $collection) {
      $query = new Query();
      $query->valueLike('!\n[ ]+\n!');
      $query->typeIs(T_WHITESPACE);

      return $collection->find($query);
    }


    /**
     * @param Collection $collection
     * @return Token
     */
    protected function getLastInvalidToken(Collection $collection) {
      $lastToken = $collection->getLast();
      if ($lastToken and preg_match('![ ]+\n*$!', $lastToken->getValue())) {
        return $lastToken;
      }
      return null;
    }

  }
