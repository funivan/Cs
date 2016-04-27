<?php

  namespace Funivan\Cs\Tools\SpacesInEmptyLines\Tests;

  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Tools\SpacesInEmptyLines\ReplaceSpacesInEmptyLinesFixer;
  use Tests\Funivan\Cs\FixerTestCase;

  /**
   *
   */
  class ReplaceSpacesInEmptyLinesFixerTest extends FixerTestCase {

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

      $this->process($input, $expect);
    }


    /**
     * @return FileTool
     */
    public function getTool() {
      return new ReplaceSpacesInEmptyLinesFixer();
    }

  }
