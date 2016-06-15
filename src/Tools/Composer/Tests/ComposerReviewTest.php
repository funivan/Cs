<?php

  namespace Funivan\Cs\Tools\Composer\Tests;

  use Funivan\Cs\Tools\Composer\ComposerReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class ComposerReviewTest extends ReviewTestCase {

    /**
     * @return array
     */
    public function getComposerFileDataProvider() {
      return [
        [
          '{
            "name":"user/package",
            "description":"test"
          }',
          [],
        ],
        [
          '{
            "name":"user/package",
          }',
          [2],
        ],

      ];
    }


    /**
     * @dataProvider getComposerFileDataProvider
     *
     * @param int $tagType
     * @param string $input
     * @param array $expectErrorLines
     * @param bool $process
     */
    public function testComposerFile($input, array $expectErrorLines) {
      $tool = new ComposerReview();
      $report = $this->process($tool, $input);

      $this->assertInvalidLinesInReport($report, $expectErrorLines);

    }

  }
