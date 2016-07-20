<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines\Tests;

  use Funivan\Cs\Tools\SpacesInEmptyLines\SpacesInEmptyLinesFixer;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class ReplaceSpacesInEmptyLinesFixerTest extends BaseTestCase {

    /**
     * @return array
     */
    public function getReplaceSpacesDataProvider() {
      return [
        [
          '<?php 
  echo 1;
...  
echo 2;',
          '<?php 
  echo 1;

echo 2;',
        ],
        [
          '<?php echo 1;',
          '<?php echo 1;',
        ],
        [
          '<?php
...
',
          '<?php

',
        ],
        [
          '<?php
...
...
...',
          '<?php


',

        ],
      ];
    }


    /**
     * @dataProvider getReplaceSpacesDataProvider
     * @param string $input
     * @param string $expect
     */
    public function testReplaceSpaces($input, $expect) {
      $input = str_replace('.', ' ', $input);
      $expect = str_replace('.', ' ', $expect);

      BaseTestCase::assertFixer(new SpacesInEmptyLinesFixer(), $input, $expect);
    }

  }
