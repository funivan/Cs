<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  class LineAfterOpenTagFixer extends AbstractLineAfterOpenTag {

    const NAME_FIXER = 'php_line_after_open_tag_fixer';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME_FIXER;
    }


    /**
     * @inheritdoc
     */
    public function getDescription() {
      return 'Set one empty line after php open tag';
    }


    /**
     * @param File $file
     * @param Report $report
     * @void
     */
    public function process(File $file, Report $report) {

      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());
      $items = $this->getInvalidStartTokens($collection);
      if (count($items) === 0) {
        return;
      }

      foreach ($items as $tokenInfo) {
        /** @var Token $token */
        $whitespace = $tokenInfo->getWhitespace();

        $token = $tokenInfo->getToken();
        $tokenValue = $token->getValue();
        $whitespaceValue = $whitespace->getValue() ? $whitespace->getValue() : '';
        $whitespace->remove();

        preg_match('!([ ]+)$!', $whitespaceValue, $endSpaces);

        $whitespaceValue = !empty($endSpaces[1]) ? $endSpaces[1] : '';

        $lines = explode("\n", $tokenValue);
        $tokenValue = reset($lines);


        $append = $tokenValue . "\n\n" . $whitespaceValue;

        $token->setValue($append);
        $report->addMessage($file, $this, 'Set one empty line after php open tag', $token->getValue());
      }

      $file->getContent()->set($collection->assemble());
    }

  }