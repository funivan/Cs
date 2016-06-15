<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

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
     * @param File $file
     * @param Report $report
     */
    public function process(File $file, Report $report) {

      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $items = $this->getInvalidStartTokens($collection);

      if (count($items) === 0) {
        return;
      }
      foreach ($items as $lineTokenData) {
        $report->addMessage($file, $this, 'Expect at one empty line after php open tag', $lineTokenData->getToken()->getLine());
      }

    }

  }