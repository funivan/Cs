<?php

  namespace Funivan\Cs\Tools\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineEndingReview extends LineEndingAbstract {

    const NAME = 'line_ending_review';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $tokens = $this->getInvalidStartTokens($file);

      foreach ($tokens as $token) {
        $report->addError($file, $this, 'Expect only LF line ending', $token->getLine());
      }

    }

  }