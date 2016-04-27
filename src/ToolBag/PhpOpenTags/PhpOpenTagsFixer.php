<?php

  namespace Funivan\Cs\ToolBag\PhpOpenTags;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\Message\Report;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpOpenTagsFixer extends AbstractPhpOpenTags {

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


      $newTag = $this->useShortTags() ? '<?php' : '<?php';
      foreach ($tags as $tag) {
        $spaces = preg_replace('!^(\S+)(\s)!', '$2', $tag->getValue());
        $tag->setValue($newTag . $spaces);
      }
    }

  }