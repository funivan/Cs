<?php

  namespace Funivan\Cs\Tools\Php\SyntaxCheck\Tests;

  use Funivan\Cs\Tools\Php\SyntaxCheck\PhpSyntaxCheckReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class PhpSyntaxCheckReviewTest extends ReviewTestCase {

    /**
     * @return array
     */
    public function getPhpFileSyntaxDataProvider() {
      return [
        [
          "<?php echo 1;",
          [],
        ],
        [
          "<?php decho 1;",
          [1],
        ],
        [
          "<?php 
          decho 1;",
          [2],
        ],
      ];
    }


    /**
     * @dataProvider getPhpFileSyntaxDataProvider
     * @param string $input
     * @param array $expectErrorLines
     */
    public function testPhpFileSyntax($input, array $expectErrorLines) {
      $report = $this->process(new PhpSyntaxCheckReview(), $input);
      $this->assertInvalidLinesInReport($report, $expectErrorLines);
    }

  }
