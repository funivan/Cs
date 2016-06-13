<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  abstract class AbstractSpacesInEmptyLines implements FileTool {

    /**
     * @codeCoverageIgnore
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension(['php', 'html'])->isValid($file);
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
      if (preg_match('![ ]+\n*$!', $lastToken->getValue())) {
        return $lastToken;
      }
      return null;
    }

  }
