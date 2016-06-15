<?php

  namespace Funivan\Cs\Tools\Php\OpenTags;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Filters\FileFilter;
  use Funivan\Cs\Fs\File;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Query\Query;

  /**
   *
   */
  abstract class PhpOpenTagsAbstract implements FileTool {

    /**
     * @var int
     */
    private $tagFormat;


    /**
     * @param int $tagFormat
     */
    public function __construct($tagFormat) {
      if (!PhpOpenTagFormat::isValidTagFormat($tagFormat)) {
        throw new \InvalidArgumentException('Invalid tag format');
      }

      $this->tagFormat = $tagFormat;
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
      return $this->tagFormat === PhpOpenTagFormat::LONG;
    }


    /**
     * @return bool
     */
    protected function useShortTags() {
      return $this->tagFormat === PhpOpenTagFormat::SHORT;
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