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
     * @var Query
     */
    private $query;


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
     * @return Query
     */
    protected function getFindQuery() {
      if ($this->query !== null) {
        return $this->query;
      }

      $this->query = new Query();
      $this->query->custom(function (Token $token) {
        return (boolean) preg_match(LineEndingAbstract::REGEX, $token->getValue());
      });

      return $this->query;
    }


    /**
     * @param FileInfo $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function getInvalidStartTokens(FileInfo $file) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      return $collection->find($this->getFindQuery());
    }

  }