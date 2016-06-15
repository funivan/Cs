<?php

  namespace Funivan\Cs\Tools\Php\OpenTags;

  /**
   *
   */
  final class PhpOpenTagFormat {

    const SHORT = 2;

    const LONG = 1;


    /**
     * @param int $tagFormat
     * @return bool
     */
    public static function isValidTagFormat($tagFormat) {
      return ($tagFormat === PhpOpenTagFormat::LONG or $tagFormat === PhpOpenTagFormat::SHORT);
    }

  }