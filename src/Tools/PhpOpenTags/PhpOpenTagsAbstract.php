<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\PhpTokenizer\Query\Query;

  /**
   *
   */
  abstract class PhpOpenTagsAbstract implements FileTool {

    const TAG_FORMAT_FULL = 1;

    const TAG_FORMAT_SHORT = 2;

    /**
     * @var null
     */
    private $tagFormat = null;


    /**
     * @param int|null $tagFormat
     */
    public function __construct($tagFormat = null) {
      // Use short tags by default
      $tagFormat = $tagFormat ? $tagFormat : self::TAG_FORMAT_SHORT;

      if ($tagFormat !== self::TAG_FORMAT_FULL and $tagFormat !== self::TAG_FORMAT_SHORT) {
        throw new \InvalidArgumentException('Invalid tag format');
      }

      $this->tagFormat = $tagFormat;
    }


    /**
     * @return string
     */
    public function getDescription() {
      return 'Use only one type of php tags according to your code style';
    }


    /**
     * @param FileInfo $file
     * @return boolean
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension(['php', 'html'])->isValid($file);
    }


    /**
     * @return bool
     */
    protected function useFullTags() {
      return $this->tagFormat === self::TAG_FORMAT_FULL;
    }


    /**
     * @return bool
     */
    protected function useShortTags() {
      return $this->tagFormat === self::TAG_FORMAT_SHORT;
    }


    /**
     * @param FileInfo $file
     * @return \Funivan\PhpTokenizer\Collection
     */
    protected function findTags(FileInfo $file) {
      $query = (new Query());
      $query->typeIs(T_OPEN_TAG);
      if ($this->useShortTags()) {
        $query->valueLike('!^<\?php\s+!'); // long php tag contains also spaces
      } else {
        $query->valueIs('<?');
      }

      $tokens = $file->getTokenizer()->getCollection();


      return $tokens->find($query);
    }


  }