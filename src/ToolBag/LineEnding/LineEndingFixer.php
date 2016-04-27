<?php

  namespace Funivan\Cs\ToolBag\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineEndingFixer extends LineEndingAbstract {

    const NAME = 'php_line_ending_fixer';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @param FileInfo $file
     * @param Report $report
     * @void
     */
    public function process(FileInfo $file, Report $report) {
      $tokens = $this->getInvalidStartTokens($file);

      foreach ($tokens as $token) {
        $report->addError($file, $this, 'Expect only LF line ending', $token->getLine());
      }

    }

  }