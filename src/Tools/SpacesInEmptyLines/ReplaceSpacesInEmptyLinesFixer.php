<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   */
  class ReplaceSpacesInEmptyLinesFixer extends AbstractSpacesInEmptyLines {

    const NAME = 'spaces_in_empty_lines_fixes';


    /**
     * @codeCoverageIgnore
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getDescription() {
      return 'Remove spaces in empty lines';
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $stripTokens = $this->findTokens($file);

      if ($stripTokens->count() === 0) {
        return;
      }

      $report->addNotice($file, $this, 'Find empty lines with spaces: ' . $stripTokens->count());

      foreach ($stripTokens as $token) {
        $value = $token->getValue();

        $value = preg_replace('!\n([ ]+)\n!', "\n\n", $value);
        $value = preg_replace("!\s+\n$!", "\n", $value);
        $token->setValue($value);
      }

    }

  }
