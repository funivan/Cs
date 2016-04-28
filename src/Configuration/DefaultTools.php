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
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsFixer;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsReview;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesFixer;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesReview;

  /**
   * List of default fixers and review tools
   */
  final class DefaultTools {

    /**
     * @return array Array<String,String>
     */
    public static function getFixTools() {
      return [
        LineEndingFixer::NAME => LineEndingFixer::class,
        LineAfterOpenTagFixer::NAME_FIXER => LineAfterOpenTagFixer::class,
        PhpOpenTagsFixer::NAME => PhpOpenTagsFixer::class,
        SpacesInEmptyLinesFixer::NAME => SpacesInEmptyLinesFixer::class,
        LineBeforeClassEndFixer::NAME => LineBeforeClassEndFixer::class,
      ];
    }


    /**
     * @return array Array<String,String>
     */
    public static function getReviewTools() {
      return [
        LineEndingReview::NAME => LineEndingReview::class,
        LineBeforeClassEndReview::NAME => LineBeforeClassEndReview::class,
        PhpFileStartReview::NAME => PhpFileStartReview::class,
        PhpSyntaxCheckReview::NAME => PhpSyntaxCheckReview::class,
        PhpFileCloseTagReview::NAME => PhpFileCloseTagReview::class,
        SpacesInEmptyLinesReview::NAME => SpacesInEmptyLinesReview::class,
        ComposerReview::NAME => ComposerReview::class,
        LineAfterOpenTagReview::NAME => LineAfterOpenTagReview::class,
        PhpOpenTagsReview::NAME => PhpOpenTagsReview::class,
      ];
    }

  }