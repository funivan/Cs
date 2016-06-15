<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

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
    public function process(File $file, Report $report) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());

      $tokens = $this->findTokens($collection);

      $lastInvalidToken = $this->getLastInvalidToken($collection);
      if (null !== $lastInvalidToken) {
        $tokens->append($lastInvalidToken);
      }

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

        $report->addMessage($file, $this, 'File contains empty lines with spaces.', $line);
      }

    }

  }