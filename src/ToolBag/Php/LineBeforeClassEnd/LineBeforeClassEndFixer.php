<?php

  namespace Funivan\Cs\ToolBag\Php\LineBeforeClassEnd;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

  /**
   *
   */
  class LineBeforeClassEndFixer extends AbstractLineBeforeClassEnd {

    const NAME = 'php_line_before_class_end_fixer';


    /**
     * @return $this
     */
    public static function createReview() {
      return new static(false);
    }


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @return string
     */
    public function getDescription() {
      return 'Set one empty line before class closing tag';
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
        $report->addMessage($file, $this, 'Set one line before closing tag', $token->getLine());
        $value = $token->getValue();

        if ($token->getType() !== T_WHITESPACE) {
          $token->setValue($value . "\n\n");
          return;
        }

        $lines = explode("\n", $value);
        $lineStart = current($lines);
        $lineEnd = end($lines);

        $token->setValue($lineStart . "\n\n" . $lineEnd);
      }

      $file->getContent()->set($collection->assemble());
    }

  }