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

      $report->addNotice($file, $this, 'Find invalid open tags: ' . $tags->count());

      $newTag = $this->useShortTags() ? '<?' : '<?php';
      foreach ($tags as $tag) {

        $spaces = preg_replace('!^(\S+)(\s)!', '$2', $tag->getValue());
        if ($spaces === $tag->getValue()) {
          $spaces = '';
        }

        $tag->setValue($newTag . $spaces);
      }

    }

  }