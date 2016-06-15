<?php

  namespace Funivan\Cs\Tools\Php\LineBeforeClassEnd;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  class LineBeforeClassEndFixer extends AbstractLineBeforeClassEnd {

    const NAME = 'php_line_before_class_end_fixer';


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

      $emptyLines = "\n" . str_repeat("\n", $this->getLinesNum());


      foreach ($tokens as $token) {
        $report->addMessage($file, $this, 'Set one line before closing tag', $token->getLine());

        $newValue = $this->getTokenNewValue($token, $emptyLines);
        $token->setValue($newValue);
      }

      $file->getContent()->set($collection->assemble());
    }


    /**
     * @param Token $token
     * @param string $emptyLines
     * @return string
     */
    protected function getTokenNewValue(Token $token, $emptyLines) {

      if ($token->getType() !== T_WHITESPACE) {
        return $token->getValue() . $emptyLines;
      }

      $lines = explode("\n", $token->getValue());
      $lineStart = current($lines);
      $lineEnd = end($lines);
      return $lineStart . $emptyLines . $lineEnd;
    }

  }