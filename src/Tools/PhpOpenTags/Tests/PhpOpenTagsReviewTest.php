<?php

  namespace Funivan\Cs\Tools\PhpOpenTags\Tests;

  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class PhpOpenTagsReviewTest extends ReviewTestCase {

    /**
     * @return FileTool
     */
    public function getTool() {
      return new PhpOpenTagsReview();
    }


    /**
     * @return array
     */
    public function getInvalidOpenTagsDataProvider() {
      return [
        [
          '<?php
?><?',
          [1],
        ],
        [
          '<?php echo 1',
          [1],
        ],
        [
          '<?php
echo 1?>

<?php echo 1',
          [1, 4],
        ],
      ];
    }


    /**
     * @dataProvider getInvalidOpenTagsDataProvider
     *
     * @param string $input
     * @param array $expectErrorLines
     */
    public function testInvalidOpenTags($input, array $expectErrorLines) {
      $report = $this->process($input);
      $this->assertInvalidLinesInReport($report, $expectErrorLines);

    }

  }
