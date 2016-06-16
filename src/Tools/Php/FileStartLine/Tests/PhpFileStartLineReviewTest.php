<?php

  namespace Funivan\Cs\Tools\Php\FileStartLine\Tests;

  use Funivan\Cs\Tools\Php\FileStartLine\PhpFileStartLineReview;

  /**
   *
   */
  class PhpFileStartLineReviewTest extends \Tests\Funivan\Cs\ReviewTestCase {

    /**
     * @return array
     */
    public function getTestFileStartDataProvider() {
      return [
        [
          '<?php echo 1',

          [],
        ],
        [
          '
          
          <?php echo 1',

          [1],
        ],
        [
          '#!/usr/bin/env php',
          [],
        ],
        [
          '#!/usr/bin/php',
          [1],
        ],
      ];
    }


    /**
     * @dataProvider getTestFileStartDataProvider
     * @param string $input
     * @param array $expectErrorLines
     */
    public function testTestFileStart($input, array $expectErrorLines) {
      $report = $this->process(new PhpFileStartLineReview(), $input);
      $this->assertInvalidLinesInReport($report, $expectErrorLines);
    }

  }
