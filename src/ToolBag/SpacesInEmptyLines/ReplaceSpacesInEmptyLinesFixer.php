<?php

  namespace Funivan\Cs\ToolBag\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   */
  class ReplaceSpacesInEmptyLinesFixer extends AbstractSpacesInEmptyLines {

    const NAME = 'replace_spaces_in_empty_lines_fixes';


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
        $token->setValue($value);
      }

    }

  }
