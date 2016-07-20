<?php

  namespace Funivan\Cs\Tools\Php\SyntaxCheck\Tests;

  use Funivan\Cs\Tools\Php\SyntaxCheck\SyntaxCheckReview;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class PhpSyntaxCheckReviewTest extends BaseTestCase {

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
      static::assertReview(new SyntaxCheckReview(), $input, $expectErrorLines);
    }

  }
