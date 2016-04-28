<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\Configuration\ToolConfigurationInterface;
  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  class PhpOpenTagsConfiguration implements ToolConfigurationInterface {

    const FIXER = 'fixer';

    const REVIEW = 'review';

    const TAG_FORMAT_FULL = 1;

    const TAG_FORMAT_SHORT = 2;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $tagFormat = null;


    /**
     * @param int $tagFormat
     * @param string $type
     */
    public function __construct($tagFormat, $type) {
      $this->setTagFormat($tagFormat);

      if ($type !== self::FIXER and $type !== self::REVIEW) {
        throw new \InvalidArgumentException('Invalid tool type id');
      }

      $this->type = $type;
    }


    /**
     * @param int $tagFormat
     * @return bool
     */
    public static function isValidTagFormat($tagFormat) {
      return ($tagFormat === self::TAG_FORMAT_FULL or $tagFormat === self::TAG_FORMAT_SHORT);
    }


    /**
     * @return string
     */
    public function getName() {
      if ($this->type === self::FIXER) {
        return \Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsFixer::NAME;
      }
      return PhpOpenTagsReview::NAME;
    }


    /**
     * @return FileTool
     */
    public function createTool() {
      if ($this->type === self::FIXER) {
        return new PhpOpenTagsFixer($this->tagFormat);
      }

      return new PhpOpenTagsReview($this->tagFormat);
    }


    /**
     * @param int $tagFormat
     * @return $this
     */
    public function setTagFormat($tagFormat) {
      if (!self::isValidTagFormat($tagFormat)) {
        throw new \InvalidArgumentException('Invalid tag format');
      }

      $this->tagFormat = $tagFormat;
      return $this;
    }

  }