<?php

  namespace Funivan\Cs\Review\Tools;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Message\Report;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;

  /**
   * @todo create fixer
   *
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpFileCloseTagReview implements FileTool {

    const NAME = 'php_closing_tag_review';


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
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->extension('php')->notDeleted()->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {

      $tokens = Collection::createFromString($file->getContent()->get());
      $closedTags = $tokens->find((new Query())->valueIs('?>'));
      foreach ($closedTags as $token) {
        $report->addError($file, $this, 'File contains ending tag', $token->getLine());
      }
    }

  }
