<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpOpenTagsFixer extends PhpOpenTagsAbstract {

    const NAME = 'php_open_tags_fixer';


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
      $message = 'Detect ' . $type . ' php tag';


      $newTag = $this->useShortTags() ? '<?' : '<?php';
      foreach ($tags as $tag) {
        $report->addMessage($file, $this, $message, $tag->getLine());

        $spaces = preg_replace('!^(\S+)(\s)!', '$2', $tag->getValue());
        if ($spaces === $tag->getValue()) {
          $spaces = '';
        }

        $tag->setValue($newTag . $spaces);
      }

      $file->getContent()->set($collection->assemble());
    }

  }