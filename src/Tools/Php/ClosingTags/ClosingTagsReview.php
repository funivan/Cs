<?php

  namespace Funivan\Cs\Tools\Php\ClosingTags;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
  use Funivan\Cs\Report\Report;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;
  use Funivan\PhpTokenizer\TokenFinder;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class ClosingTagsReview implements FileTool {

    const NAME = 'php_closing_tags_review';


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
      return 'Closing tag \'?>\' is redundant for files containing only PHP code.';
    }


    /**
     * @inheritdoc
     */
    public function canProcess(File $file) {
      return (new FileFilter())->extension(['php'])->notDeleted()->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(File $file, Report $report) {

      $tokens = Collection::createFromString($file->getContent()->get());
      $closedTags = (new TokenFinder($tokens))->find((new Query())->typeIs(T_CLOSE_TAG));
      foreach ($closedTags as $token) {
        $report->addMessage($file, $this, 'File contains closing tag', $token->getLine());
      }
    }

  }
