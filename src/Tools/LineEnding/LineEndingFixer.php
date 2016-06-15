<?php

  namespace Funivan\Cs\Tools\LineEnding;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
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
     * @param File $file
     * @param Report $report
     * @void
     */
    public function process(File $file, Report $report) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $tokens = $collection->find($this->getFindQuery());

      foreach ($tokens as $token) {
        $value = $token->getValue();
        $value = preg_replace(self::REGEX, "\n", $value);
        $token->setValue($value);

        $report->addMessage($file, $this, 'Replace invalid line ending', $token->getLine());
      }


      $file->getContent()->set($collection->assemble());
    }

  }