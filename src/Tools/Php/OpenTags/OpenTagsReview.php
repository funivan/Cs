<?php

  namespace Funivan\Cs\Tools\Php\OpenTags;

  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

  /**
   *
   */
  class OpenTagsReview extends PhpOpenTagsAbstract {

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
    public function process(File $file, Report $report) {
      $collection = \Funivan\PhpTokenizer\Collection::createFromString($file->getContent()->get());

      $tags = $this->findTags($collection);
      if ($tags->count() === 0) {
        return;
      }

      $type = $this->useFullTags() ? 'long' : 'short';

      $message = 'You should use only ' . $type . ' php tags';


      foreach ($tags as $tag) {
        $report->addMessage($file, $this, $message, $tag->getLine());
      }

    }

  }