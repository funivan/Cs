<?php

  namespace Funivan\Cs\Tools\Php\OpenTags\Tests;

  use Funivan\Cs\Tools\Php\OpenTags\OpenTagsFixer;
  use Funivan\Cs\Tools\Php\OpenTags\PhpOpenTagFormat;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class PhpOpenTagsFixerTest extends BaseTestCase {


    /**
     * @return array
     */
    public function getConvertTagsDataProvider() {
      return [
        [
          PhpOpenTagFormat::SHORT,
          '<?php
?><?',
          '<?
?><?',
        ],
        [
          PhpOpenTagFormat::SHORT,
          '<?php echo 1',
          '<? echo 1',
        ],
        [
          PhpOpenTagFormat::SHORT,
          '<?php
echo 1',
          '<?
echo 1',
        ],

      ];
    }


    /**
     * @dataProvider getConvertTagsDataProvider
     * @param int $tagFormat
     * @param string $input
     * @param string $expect
     */
    public function testConvertTags($tagFormat, $input, $expect) {
      self::assertFixer(new OpenTagsFixer($tagFormat), $input, $expect);
    }

  }
