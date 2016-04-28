<?php

  namespace Funivan\Cs\Tools\Tests\LineEnding;

  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Tools\LineEnding\LineEndingReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class LineEndingReviewTest extends ReviewTestCase {

    /**
     * @return FileTool
     */
    public function getTool() {
      return new LineEndingReview();
    }


    /**
     * @return array
     */
    public function getReplaceSpacesDataProvider() {
      return [
        [
          'code' => '<?php\n 
  echo 1;\r',
          'lines' => [2],
        ],
        [
          'code' => '<?php echo 1;',
          'lines' => [],
        ],
        [
          'code' => '<?php\r\n
          echo 1;\n
          \r',
          'lines' => [1, 2],
        ],
        [
          'code' => '<?php\n
\r\n
\r\n',
          'lines' => [2],

        ],
      ];
    }


    /**
     * @dataProvider getReplaceSpacesDataProvider
     * @param string $input
     * @param array $expectErrorLines
     */
    public function testReviewInvalidLines($input, array $expectErrorLines) {
      $map = [
        '\r' => "\r",
        '\n' => "\n",
      ];

      $input = str_replace("\n", '', $input);
      $input = strtr($input, $map);

      $report = $this->process($input);
      $this->assertInvalidLinesInReport($report, $expectErrorLines);
    }


  }
