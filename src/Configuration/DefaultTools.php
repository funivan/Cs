<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Review\Tools\PhpFileCloseTagReview;
  use Funivan\Cs\Review\Tools\PhpFileStartReview;
  use Funivan\Cs\Review\Tools\PhpSyntaxCheckReview;
  use Funivan\Cs\Tools\Composer\ComposerReview;
  use Funivan\Cs\Tools\LineEnding\LineEndingFixer;
  use Funivan\Cs\Tools\LineEnding\LineEndingReview;
  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagFixer;
  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagReview;
  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndReview;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagFormat;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsFixer;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsReview;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesFixer;
  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesReview;

  /**
   * List of default fixers and review tools
   *
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  final class DefaultTools {

    /**
     * @return FileTool[]
     */
    public static function getFixers() {
      return [
        new LineEndingFixer(),
        new LineAfterOpenTagFixer(),

        new SpacesInEmptyLinesFixer(),
        new LineBeforeClassEndFixer(),

        new PhpOpenTagsFixer(PhpOpenTagFormat::LONG),
      ];
    }


    /**
     * @return FileTool[]
     */
    public static function getReviews() {
      return [
        new LineEndingReview(),
        new LineBeforeClassEndReview(),
        new PhpFileStartReview(),
        new PhpSyntaxCheckReview(),
        new PhpFileCloseTagReview(),
        new SpacesInEmptyLinesReview(),
        new ComposerReview(),
        new LineAfterOpenTagReview(),

        new PhpOpenTagsReview(PhpOpenTagFormat::LONG),
      ];
    }

  }