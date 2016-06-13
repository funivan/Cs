<?php

  namespace Funivan\Cs\ToolBag\Php\LineBeforeClassEnd;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

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
     * @param FileInfo $file
     * @param Report $report
     * @void
     */
    public function process(FileInfo $file, Report $report) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $tokens = $this->getInvalidTokens($collection);

      foreach ($tokens as $token) {
        $report->addNotice($file, $this, 'Set one line before closing tag', $token->getLine());
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