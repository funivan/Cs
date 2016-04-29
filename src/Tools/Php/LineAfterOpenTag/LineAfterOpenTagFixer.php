<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;
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
     * @param FileInfo $file
     * @param Report $report
     * @void
     */
    public function process(FileInfo $file, Report $report) {

      $items = $this->getInvalidStartTokens($file);
      if (count($items) === 0) {
        return;
      }

      //$report->addNotice($file, $this, 'Add empty line after tag');


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
        $report->addNotice($file, $this, 'Set one empty line after php open tag', $token->getValue());
      }
    }

  }