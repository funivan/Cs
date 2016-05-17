<?php

  namespace Funivan\Cs\ToolBag\Php\LineBeforeClassEnd;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineBeforeClassEndReview extends AbstractLineBeforeClassEnd {

    const NAME = 'php_line_before_class_end_review';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @inheritdoc
     */
    public function getDescription() {
      return 'Check if there is one empty line before class closing tag';
    }


    /**
     * @param FileInfo $file
     * @param Report $report
     * @void
     */
    public function process(FileInfo $file, Report $report) {
      $tokens = $this->getInvalidTokens($file);

      foreach ($tokens as $token) {
        $report->addError($file, $this, 'Expect one empty line before class end', $token->getLine());
      }
    }

  }