<?php

  namespace Funivan\Cs\ToolBag\PhpOpenTagLineDelimiter;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  class LineAfterOpenTagFixer extends LineAfterOpenTag {

    const NAME_FIXER = 'php_open_tag_empty_line_fixer';


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
      return 'Add 1 empty line after php open tag';
    }


    /**
     * @param FileInfo $file
     * @param Report $report
     * @void
     */
    public function process(FileInfo $file, Report $report) {

      $tokens = $this->getInvalidStartTokens($file);
      if (empty($tokens)) {
        return;
      }

      $report->addNotice($file, $this, 'Add empty line after tag');

      foreach ($tokens as $tokenInfo) {
        /** @var Token $token */
        $token = $tokenInfo[1];
        $num = $tokenInfo[0];

        $append = str_repeat("\n", (3 - $num));

        $token->setValue($token->getValue() . $append);
      }
    }

  }