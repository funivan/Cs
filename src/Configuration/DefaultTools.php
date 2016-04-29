<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\Review\Tools\ComposerReview;
  use Funivan\Cs\Review\Tools\PhpFileCloseTagReview;
  use Funivan\Cs\Review\Tools\PhpFileStartReview;
  use Funivan\Cs\Review\Tools\PhpSyntaxCheckReview;
  use Funivan\Cs\ToolBag\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
  use Funivan\Cs\ToolBag\Php\LineBeforeClassEnd\LineBeforeClassEndReview;
  use Funivan\Cs\ToolBag\PhpOpenTagLineDelimiter\LineAfterOpenTagFixer;
  use Funivan\Cs\ToolBag\PhpOpenTagLineDelimiter\LineAfterOpenTagReview;
  use Funivan\Cs\Tools\LineEnding\LineEndingFixer;
  use Funivan\Cs\Tools\LineEnding\LineEndingReview;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsConfiguration;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesFixer;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesReview;

  /**
   * List of default fixers and review tools
   */
  final class DefaultTools {

    /**
     * @return ToolConfiguration[]
     */
    public static function getFixers() {
      return [
        new ToolConfiguration(LineEndingFixer::NAME, LineEndingFixer::class),
        new ToolConfiguration(LineAfterOpenTagFixer::NAME_FIXER, LineAfterOpenTagFixer::class),
        new ToolConfiguration(SpacesInEmptyLinesFixer::NAME, SpacesInEmptyLinesFixer::class),
        new ToolConfiguration(LineBeforeClassEndFixer::NAME, LineBeforeClassEndFixer::class),

        new PhpOpenTagsConfiguration(PhpOpenTagsConfiguration::TAG_FORMAT_LONG, PhpOpenTagsConfiguration::FIXER),
      ];
    }


    /**
     * @return ToolConfiguration[]
     */
    public static function getReviews() {
      return [
        new ToolConfiguration(LineEndingReview::NAME, LineEndingReview::class),
        new ToolConfiguration(LineBeforeClassEndReview::NAME, LineBeforeClassEndReview::class),
        new ToolConfiguration(PhpFileStartReview::NAME, PhpFileStartReview::class),
        new ToolConfiguration(PhpSyntaxCheckReview::NAME, PhpSyntaxCheckReview::class),
        new ToolConfiguration(PhpFileCloseTagReview::NAME, PhpFileCloseTagReview::class),
        new ToolConfiguration(SpacesInEmptyLinesReview::NAME, SpacesInEmptyLinesReview::class),
        new ToolConfiguration(ComposerReview::NAME, ComposerReview::class),
        new ToolConfiguration(LineAfterOpenTagReview::NAME, LineAfterOpenTagReview::class),

        new PhpOpenTagsConfiguration(PhpOpenTagsConfiguration::TAG_FORMAT_LONG, PhpOpenTagsConfiguration::REVIEW),
      ];
    }

  }