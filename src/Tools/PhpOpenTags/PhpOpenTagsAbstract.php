<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Filters\FileFilter;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;

  /**
   *
   */
  abstract class PhpOpenTagsAbstract implements FileTool {

    const TAG_FORMAT_SHORT = 2;

    const TAG_FORMAT_LONG = 1;

    /**
     * @var null
     */
    private $tagFormat = null;


    /**
     * @param int|null $tagFormat
     */
    public function __construct($tagFormat = null) {
      if (!self::isValidTagFormat($tagFormat)) {
        throw new \InvalidArgumentException('Invalid tag format');
      }

      $this->tagFormat = $tagFormat;
    }


    /**
     * @param int $tagFormat
     * @return bool
     */
    public static function isValidTagFormat($tagFormat) {
      return ($tagFormat === self::TAG_FORMAT_LONG or $tagFormat === self::TAG_FORMAT_SHORT);
    }


    /**
     * @return string
     */
    public function getDescription() {
      $type = $this->useFullTags() ? 'long' : 'short';
      return 'Use only ' . $type . ' php tags according to your code style';
    }


    /**
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file) {
      return (new FileFilter())->notDeleted()->extension(['php', 'html'])->isValid($file);
    }


    /**
     * @return bool
     */
    protected function useFullTags() {
      return $this->tagFormat === self::TAG_FORMAT_LONG;
    }


    /**
     * @return bool
     */
    protected function useShortTags() {
      return $this->tagFormat === self::TAG_FORMAT_SHORT;
    }


    /**
     * @param \Funivan\PhpTokenizer\Collection $collection
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function findTags(Collection $collection) {
      $query = (new Query());
      $query->typeIs(T_OPEN_TAG);
      if ($this->useShortTags()) {
        $query->valueLike('!^<\?php\s+!'); // long php tag contains also spaces
      } else {
        $query->valueIs('<?');
      }

      return $collection->find($query);
    }

  }