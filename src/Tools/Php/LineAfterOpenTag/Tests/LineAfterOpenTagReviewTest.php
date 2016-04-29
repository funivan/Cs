<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag\Tests;

  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class LineAfterOpenTagReviewTest extends ReviewTestCase {

    /**
     * @return array
     */
    public function getLineAfterOpenTagDataProvider() {
      return [
        [
          '<?php



',
          [1],
        ],
        [
          '<?php

echo 1;
',
          [],
        ],
        [
          '<?php

echo 1;?>
<?


',
          [4],
        ],
      ];
    }


    /**
     * @dataProvider getLineAfterOpenTagDataProvider
     * @param string $input
     * @param array $errorLines
     */
    public function testLineAfterOpenTag($input, array $errorLines) {

      $tool = new LineAfterOpenTagReview();
      $report = $this->process($tool, $input);
      $this->assertInvalidLinesInReport($report, $errorLines);
    }

  }
