<?php

  namespace Funivan\Cs\Tools\Php\LineBeforeClassEnd\Tests;

  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class LineBeforeClassEndFixerTest extends BaseTestCase {

    /**
     * @return array
     */
    public function getLineBeforeClassEndDataProvider() {
      return [
        [
          0,
          '<?php class A{
            cont T = 1;

          }',
          '<?php class A{
            cont T = 1;
          }',
        ],
        [
          0,
          '<?php class A{ cont T = 1; }',
          '<?php class A{ cont T = 1; }',
        ],
        [
          1,
          '<?php class A{
            cont T = 1;
          }',
          '<?php class A{
            cont T = 1;

          }',
        ],
        [
          2,
          '<?php class A{ cont T = 1;}',
          '<?php class A{ cont T = 1;


}',
        ],
      ];
    }


    /**
     * @dataProvider getLineBeforeClassEndDataProvider
     * @param int $linesNum
     * @param string $input
     * @param string $expect
     */
    public function testLineBeforeClassEnd($linesNum, $input, $expect) {
      $tool = new LineBeforeClassEndFixer();
      $tool->setLinesNum($linesNum);

      self::assertFixer($tool, $input, $expect);
    }

  }
