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
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());

      $tags = $this->findTags($collection);
      if ($tags->count() === 0) {
        return;
      }

      $type = $this->useFullTags() ? 'long' : 'short';

      $message = 'You should use only ' . $type . ' php tags';


      foreach ($tags as $tag) {
        $report->addError($file, $this, $message, $tag->getLine());
      }

    }

  }