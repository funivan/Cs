<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

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
    public function process(FileInfo $file, Report $report) {
      $tags = $this->findTags($file);
      if ($tags->count() === 0) {
        return;
      }


      $type = $this->useFullTags() ? 'long' : 'short';
      $message = 'Detect ' . $type . ' php tag';


      $newTag = $this->useShortTags() ? '<?' : '<?php';
      foreach ($tags as $tag) {
        $report->addNotice($file, $this, $message, $tag->getLine());

        $spaces = preg_replace('!^(\S+)(\s)!', '$2', $tag->getValue());
        if ($spaces === $tag->getValue()) {
          $spaces = '';
        }

        $tag->setValue($newTag . $spaces);
      }

    }

  }