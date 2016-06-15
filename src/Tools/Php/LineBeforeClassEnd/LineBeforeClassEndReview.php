<?php

  namespace Funivan\Cs\Tools\Php\LineBeforeClassEnd;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

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
     * @param File $file
     * @param Report $report
     * @void
     */
    public function process(File $file, Report $report) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $tokens = $this->getInvalidTokens($collection);

      foreach ($tokens as $token) {
        $report->addMessage($file, $this, 'Expect one empty line before class end', $token->getLine());
      }
    }

  }