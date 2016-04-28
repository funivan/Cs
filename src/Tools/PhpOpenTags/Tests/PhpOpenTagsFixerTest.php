<?php

  namespace Funivan\Cs\Tools\PhpOpenTags\Tests;

  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsFixer;
  use Tests\Funivan\Cs\FixerTestCase;

  /**
   *
   */
  class PhpOpenTagsFixerTest extends FixerTestCase {

    /**
     * @return FileTool
     */
    public function getTool() {
      return new PhpOpenTagsFixer();
    }


    /**
     * @return array
     */
    public function getConvertTagsDataProvider() {
      return [
        [
          '<?php
?><?',
          '<?
?><?',
        ],
        [
          '<?php echo 1',
          '<? echo 1',
        ],
        [
          '<?php
echo 1',
          '<?
echo 1',
        ],

      ];
    }


    /**
     * @dataProvider getConvertTagsDataProvider
     * @param string $input
     * @param string $expect
     */
    public function testConvertTags($input, $expect) {
      $this->process($input, $expect);
    }

  }
