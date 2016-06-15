<?php

  namespace Funivan\Cs\Tools\PhpOpenTags\Tests;

  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagFormat;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsFixer;
  use Tests\Funivan\Cs\FixerTestCase;

  /**
   *
   */
  class PhpOpenTagsFixerTest extends FixerTestCase {


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
      $this->process(new PhpOpenTagsFixer($tagFormat), $input, $expect);
    }

  }
