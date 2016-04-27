<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Query\Query;

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
     * @param FileInfo $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function findTokens(FileInfo $file) {
      $tokens = $file->getTokenizer()->getCollection();

      $query = new Query();
      $query->valueLike('!\n[ ]+\n!');
      $query->typeIs(T_WHITESPACE);

      $stripTokens = $tokens->find($query);

      $lastToken = $tokens->getLast();
      if (preg_match('![ ]+\n*$!', $lastToken->getValue())) {
        $stripTokens->append($lastToken);
      }

      return $stripTokens;
    }

  }
