<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   */
  class SpacesInEmptyLinesFixer extends AbstractSpacesInEmptyLines {

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
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $stripTokens = $this->findTokens($collection);


      $invalidTokensNum = $stripTokens->count();

      $lastInvalidToken = $this->getLastInvalidToken($collection);

      if (null !== $lastInvalidToken) {
        $invalidTokensNum++;
      }

      if ($invalidTokensNum === 0) {
        return;
      }

      $report->addNotice($file, $this, 'Find empty lines with spaces: ' . $invalidTokensNum);

      foreach ($stripTokens as $token) {
        $value = $token->getValue();
        $token->setValue($this->replaceEmptyLines($value));
      }

      if (null !== $lastInvalidToken) {
        $value = $lastInvalidToken->getValue();
        $value = $this->replaceEmptyLines($value);
        $value = preg_replace('![ ]+(\n*)$!', '$1', $value);
        $value = preg_replace('!^[ ]+!', '', $value);
        $lastInvalidToken->setValue($value);
      }

      $file->getContent()->set($collection->assemble());
    }


    /**
     * @param string $value
     * @return string
     */
    protected function replaceEmptyLines($value) {
      return preg_replace('!\n([ ]+)\n!', "\n\n", $value);
    }

  }
