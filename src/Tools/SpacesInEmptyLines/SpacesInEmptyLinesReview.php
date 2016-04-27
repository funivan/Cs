<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class SpacesInEmptyLinesReview extends AbstractSpacesInEmptyLines {

    const NAME = 'spaces_in_empty_lines_review';


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
      return 'Check if file contains empty lines with spaces';
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $tokens = $this->findTokens($file);

      if ($tokens->count() === 0) {
        return;
      }

      $lines = [];
      foreach ($tokens as $token) {
        $line = $token->getLine();
        $line++; # Our token start in previous line
        if (isset($lines[$line])) {
          continue;
        }

        $lines[$line] = true;

        $report->addError($file, $this, 'File contains empty lines with spaces.', $line);
      }

    }

  }