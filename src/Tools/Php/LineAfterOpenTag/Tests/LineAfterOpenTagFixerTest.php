<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag\Tests;

  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagFixer;
  use Tests\Funivan\Cs\FixerTestCase;

  /**
   *
   */
  class LineAfterOpenTagFixerTest extends FixerTestCase {

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
          '<? echo 1;',
          '<?

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
      ];
    }


    /**
     * @dataProvider getSetEmptyLineDataProvider
     * @param string $input
     * @param string $expect
     */
    public function testSetEmptyLine($input, $expect) {
      $this->process(new LineAfterOpenTagFixer(), $input, $expect);
    }

  }
