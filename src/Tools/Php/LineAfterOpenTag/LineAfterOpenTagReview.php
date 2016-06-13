<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineAfterOpenTagReview extends AbstractLineAfterOpenTag {

    const NAME = 'php_line_after_open_tag_review';


    /**
     * @return string
     */
    public function getDescription() {
      return 'Expect one empty line after php open tag';
    }


    /**
     * Return unique string of the tool
     * Review tools should have ending `_review`
     * Fixer tools should have ending `_fixer`
     *
     * @return string
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @param FileInfo $file
     * @param Report $report
     */
    public function process(FileInfo $file, Report $report) {

      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $items = $this->getInvalidStartTokens($collection);

      if (count($items) === 0) {
        return;
      }
      foreach ($items as $lineTokenData) {
        $report->addError($file, $this, 'Expect at one empty line after php open tag', $lineTokenData->getToken()->getLine());
      }

    }

  }