<?php

  namespace Funivan\Cs\ToolBag\PhpOpenTags;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  class PhpOpenTagsReview extends AbstractPhpOpenTags {

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

      $message = 'Find invalid open tags (' . $tags->count() . ').';
      if ($this->useShortTags()) {
        $message = $message . ' You should use only short php tags';
      } else {
        $message = $message . ' You should not use short php tags. Only full php tags allowed';
      }
      $report->addError($file, $this, $message);
    }

  }