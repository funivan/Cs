<?php

  namespace Funivan\Cs\ToolBag\PhpOpenTagLineDelimiter;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineAfterOpenTagReview extends LineAfterOpenTag {

    const NAME = 'php_open_tag_empty_line_review';


    public function getDescription() {
      return 'Expect at least one empty line after php open tag';
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

      $tokens = $this->getInvalidStartTokens($file);

      if (count($tokens) === 0) {
        return;
      }

      $report->addError($file, $this, 'Expect at least one empty line after php open tag', 0);
    }

  }