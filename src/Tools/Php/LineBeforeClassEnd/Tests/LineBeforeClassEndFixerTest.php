<?php

  namespace Funivan\Cs\Tools\Php\LineBeforeClassEnd\Tests;

  use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
  use Tests\Funivan\Cs\FixerTestCase;

  /**
   *
   */
  class LineBeforeClassEndFixerTest extends FixerTestCase {

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
     */
    public function testLineBeforeClassEnd($linesNum, $input, $expect) {
      $tool = new LineBeforeClassEndFixer();
      $tool->setLinesNum($linesNum);


      $this->process($tool, $input, $expect);
    }

  }
