<?php

  namespace Funivan\Cs\Tools\LineEnding;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
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
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file) {
      return (new FileFilter())->mimeType('text')->notDeleted()->isValid($file);
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
     * @param File $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function getInvalidStartTokens(File $file) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      return $collection->find($this->getFindQuery());
    }

  }