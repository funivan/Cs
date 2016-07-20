<?php

  namespace Funivan\Cs\Tools\LineEnding\Tests;

  use Funivan\Cs\Tools\LineEnding\LineEndingFixer;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class LineEndingFixerTest extends \Tests\Funivan\Cs\BaseTestCase {

    /**
     * @return array
     */
    public function getReplaceSpacesDataProvider() {
      return [
        [
          '<?php\n 
  echo 1;\r',
          '<?php\n 
  echo 1;\n',
        ],
        [
          '<?php echo 1;',
          '<?php echo 1;',
        ],
        [
          '<?php\r\n
          echo 1;\n
          \r',
          '<?php\n
          echo 1;\n
          \n',

        ],
        [
          '<?php\n
\n
\n',
          '<?php\n
\n
\n',

        ],
      ];
    }


    /**
     * @dataProvider getReplaceSpacesDataProvider
     * @param string $input
     * @param string $expect
     */
    public function testReplaceInvalidLines($input, $expect) {
      $map = [
        '\r' => "\r",
        '\n' => "\n",
      ];


      $input = str_replace("\n", '', $input);
      $expect = str_replace("\n", '', $expect);
      $input = strtr($input, $map);
      $expect = strtr($expect, $map);

      \Tests\Funivan\Cs\BaseTestCase::assertFixer(new LineEndingFixer(), $input, $expect);
    }

  }
