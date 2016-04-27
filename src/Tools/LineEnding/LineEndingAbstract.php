<?php

  namespace Funivan\Cs\Tools\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Query\Query;
  use Funivan\PhpTokenizer\Token;

  /**
   * @todo add configuration. User specify
   */
  abstract class LineEndingAbstract implements FileTool {

    /**
     * @var array
     */
    private static $lineEndings = [
      'crlf' => "\r\n",
      'lf' => "\n",
      'cr' => "\r",
    ];

    const REGEX = '!\r\n?!';


    /**
     * @codeCoverageIgnore
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->mimeType('text')->notDeleted()->isValid($file);
    }


    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getDescription() {
      return 'Use correct line ending';
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