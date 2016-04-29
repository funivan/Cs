<?php

  namespace Funivan\Cs\Tools\PhpOpenTags\Tests;

  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsConfiguration;
  use Funivan\Cs\Tools\PhpOpenTags\PhpOpenTagsReview;
  use Tests\Funivan\Cs\ReviewTestCase;

  /**
   *
   */
  class PhpOpenTagsReviewTest extends ReviewTestCase {


    /**
     * @return array
     */
    public function getInvalidOpenTagsDataProvider() {
      return [
        [
          PhpOpenTagsConfiguration::TAG_FORMAT_LONG,
          '<?php
          echo 1',
          [],
        ],
        [
          PhpOpenTagsConfiguration::TAG_FORMAT_LONG,
          '<?
          echo 1',
          [1],
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          PhpOpenTagsConfiguration::TAG_FORMAT_LONG,
          '<?php 
          echo 1;?>
          <? echo 1 ?>
          
          <?
          ',
          [3, 5],
          'process' => (boolean) ini_get('short_open_tag'),
        ],

        [
          PhpOpenTagsConfiguration::TAG_FORMAT_SHORT,
          '<?php
?><?',
          [1],
        ],
        [
          PhpOpenTagsConfiguration::TAG_FORMAT_SHORT,
          '<?php echo 1',
          [1],
        ],
        [
          PhpOpenTagsConfiguration::TAG_FORMAT_SHORT,
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
     * @param int $tagType
     * @param string $input
     * @param array $expectErrorLines
     * @param bool $process
     */
    public function testInvalidOpenTags($tagType, $input, array $expectErrorLines, $process = true) {
      if ($process===false) {
        $this->markTestSkipped('PHP short open tags are not enabled.');
        return;
      }
      $tool = new PhpOpenTagsReview($tagType);
      $report = $this->process($tool, $input);
      $this->assertInvalidLinesInReport($report, $expectErrorLines);

    }

  }
