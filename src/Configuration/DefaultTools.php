<?php

  namespace Funivan\Cs\Configuration;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Tools\Composer\ComposerReview;
  use Funivan\Cs\Tools\LineEnding\LineEndingFixer;
  use Funivan\Cs\Tools\LineEnding\LineEndingReview;
  use Funivan\Cs\Tools\Php\ClosingTags\ClosingTagsReview;
  use Funivan\Cs\Tools\Php\FileStartLine\FileStartLineReview;
  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagFixer;
  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagReview;
  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndReview;
  use Funivan\Cs\Tools\Php\OpenTags\PhpOpenTagFormat;
  use Funivan\Cs\Tools\Php\OpenTags\OpenTagsFixer;
  use Funivan\Cs\Tools\Php\OpenTags\OpenTagsReview;
  use Funivan\Cs\Tools\Php\ReturnTypeFormat\ReturnTypeFormatFixer;
  use Funivan\Cs\Tools\Php\SyntaxCheck\SyntaxCheckReview;
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

        new OpenTagsFixer(PhpOpenTagFormat::LONG),
        new ReturnTypeFormatFixer(),
      ];
    }


    /**
     * @return FileTool[]
     */
    public static function getReviews() {
      return [
        new LineEndingReview(),
        new LineBeforeClassEndReview(),
        new FileStartLineReview(),
        new SyntaxCheckReview(),
        new ClosingTagsReview(),
        new SpacesInEmptyLinesReview(),
        new ComposerReview(),
        new LineAfterOpenTagReview(),

        new OpenTagsReview(PhpOpenTagFormat::LONG),
      ];
    }

  }