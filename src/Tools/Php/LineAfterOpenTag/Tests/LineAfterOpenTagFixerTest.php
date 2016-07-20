<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag\Tests;

  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagFixer;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class LineAfterOpenTagFixerTest extends BaseTestCase {


    /**
     * @return array
     */
    public function getSetEmptyLineDataProvider() {
      return [
        [
          '<?php


echo 1;',
          '<?php

echo 1;',

        ],
        [
          '<?php echo 1;',
          '<?php 

echo 1;',
        ],
        [
          '<?php
        echo 1;',
          '<?php

        echo 1;',
        ],
        [
          '<? echo 1;',
          '<?

 echo 1;',
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          '<?
echo 1;',
          '<?

echo 1;',
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          '<?
echo 1;',
          '<?

echo 1;',
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          '<?


echo 1;',
          '<?

echo 1;',
          'process' => (boolean) ini_get('short_open_tag'),
        ],
      ];
    }


    /**
     * @dataProvider getSetEmptyLineDataProvider
     * @param string $input
     * @param string $expect
     * @param bool $process
     */
    public function testSetEmptyLine($input, $expect, $process = true) {
      if ($process === false) {
        static::markTestSkipped('PHP short open tags are not enabled.');
        return;
      }

      self::assertFixer(new LineAfterOpenTagFixer(), $input, $expect);
    }

  }
