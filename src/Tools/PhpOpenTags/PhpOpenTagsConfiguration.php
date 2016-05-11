<?php

  namespace Funivan\Cs\Tools\PhpOpenTags;

  use Funivan\Cs\Configuration\ToolConfigurationInterface;
  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  class PhpOpenTagsConfiguration implements ToolConfigurationInterface {

    const TAG_FORMAT_LONG = 1;

    const TAG_FORMAT_SHORT = 2;

    /**
     * @var string
     */
    private $toolName;

    /**
     * @var int
     */
    private $tagFormat = null;


    /**
     * @param string $toolName Tool name
     * @param int $tagFormat
     */
    public function __construct($toolName, $tagFormat) {
      $this->setTagFormat($tagFormat);

      if ($toolName !== PhpOpenTagsFixer::NAME and $toolName !== PhpOpenTagsReview::NAME) {
        throw new \InvalidArgumentException('Invalid tool name');
      }

      $this->toolName = $toolName;
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
    public function getName() {
      return $this->toolName;
    }


    /**
     * @return FileTool
     */
    public function createTool() {
      if ($this->toolName === PhpOpenTagsFixer::NAME) {
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