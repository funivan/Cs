<?php

  namespace Funivan\Cs\ToolBag\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineEndingReview extends LineEndingAbstract {

    const NAME = 'php_line_ending_review';


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
        $value = $token->getValue();
        $value = preg_replace(self::REGEX, "\n", $value);
        $token->setValue($value);

        $report->addNotice($file, $this, 'Replace invalid line ending', $token->getLine());
      }

    }

  }