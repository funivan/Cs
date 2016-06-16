<?php

  namespace Funivan\Cs\Tools\Php\ClosingTags\Tests;

  use Funivan\Cs\Tools\Php\ClosingTags\PhpFileClosingTagsReview;


  /**
   *
   */
  class PhpFileClosingTagsReviewTest extends \Tests\Funivan\Cs\ReviewTestCase {

    /**
     * @return array
     */
    public function getCheckClosingTagsDataProvider() {
      return [
        [
          "<?php ",
          [],
        ],
        [
          "<?php 
          echo 123;
          ",
          [],
        ],

        [
          "<?php echo 1 ?> ",
          [1],
        ],
        [
          "<?php echo 1 ?> <?php
          
          ?>",
          [1, 3],
        ],

      ];
    }


    /**
     * @dataProvider getCheckClosingTagsDataProvider
     * @param string $input
     * @param array $invalidLines
     */
    public function testCheckClosingTags($input, array $invalidLines) {
      $report = $this->process(new PhpFileClosingTagsReview(), $input);
      $this->assertInvalidLinesInReport($report, $invalidLines);
    }

  }
