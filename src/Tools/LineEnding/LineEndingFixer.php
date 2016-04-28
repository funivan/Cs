<?php

  namespace Funivan\Cs\Tools\LineEnding;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class LineEndingFixer extends LineEndingAbstract {

    const NAME = 'line_ending_fixer';


    /**
     * @codeCoverageIgnore
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
        $value = $token->getValue();
        $value = preg_replace(self::REGEX, "\n", $value);
        $token->setValue($value);

        $report->addNotice($file, $this, 'Replace invalid line ending', $token->getLine());
      }
    }

  }