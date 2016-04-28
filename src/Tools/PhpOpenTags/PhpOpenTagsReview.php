<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class PhpOpenTagsReview extends PhpOpenTagsAbstract {

    const NAME = 'php_open_tags_review';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $tags = $this->findTags($file);
      if ($tags->count() === 0) {
        return;
      }

      $type = $this->useFullTags() ? 'full' : 'short';

      $message = 'You should use only ' . $type . ' php tags';


      foreach ($tags as $tag) {
        $report->addError($file, $this, $message, $tag->getLine());
      }

    }

  }