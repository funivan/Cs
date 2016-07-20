<?php

  namespace Funivan\Cs\Tools\Php\FileStartLine\Tests;

  use Funivan\Cs\Tools\Php\FileStartLine\FileStartLineReview;

  /**
   *
   */
  class PhpFileStartLineReviewTest extends \Tests\Funivan\Cs\BaseTestCase {

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
      static::assertReview(new FileStartLineReview(), $input, $expectErrorLines);
    }

  }
