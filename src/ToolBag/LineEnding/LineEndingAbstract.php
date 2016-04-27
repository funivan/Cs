<?php

  namespace Funivan\Cs\ToolBag\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Query\Query;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  abstract class LineEndingAbstract implements FileTool {

    const REGEX = '~\r\n?~';


    /**
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->mimeType('text')->notDeleted()->isValid($file);
    }


    /**
     * @return string
     */
    public function getDescription() {
      return 'Use LF line ending';
    }


    /**
     * @param FileInfo $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function getInvalidStartTokens(FileInfo $file) {

      $collection = $file->getTokenizer()->getCollection();
      $query = new Query();
      $query->custom(function (Token $token) {
        return (boolean) preg_match(LineEndingAbstract::REGEX, $token->getValue());
      });

      return $collection->find($query);
    }

  }