<?php

  namespace Funivan\Cs\Tools\PhpOpenTags\Tests;

  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsAbstract;
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
          PhpOpenTagsAbstract::TAG_FORMAT_SHORT,
          '<?php
?><?',
          '<?
?><?',
        ],
        [
          PhpOpenTagsAbstract::TAG_FORMAT_SHORT,
          '<?php echo 1',
          '<? echo 1',
        ],
        [
          PhpOpenTagsAbstract::TAG_FORMAT_SHORT,
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
