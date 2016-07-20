<?php

  namespace Funivan\Cs\Tools\Php\OpenTags\Tests;

  use Funivan\Cs\Tools\Php\OpenTags\OpenTagsReview;
  use Funivan\Cs\Tools\Php\OpenTags\PhpOpenTagFormat;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class PhpOpenTagsReviewTest extends BaseTestCase {


    /**
     * @return array
     */
    public function getInvalidOpenTagsDataProvider() {
      return [
        [
          PhpOpenTagFormat::LONG,
          '<?php
          echo 1',
          [],
        ],
        [
          PhpOpenTagFormat::LONG,
          '<?
          echo 1',
          [1],
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          PhpOpenTagFormat::LONG,
          '<?php 
          echo 1;?>
          <? echo 1 ?>
          
          <?
          ',
          [3, 5],
          'process' => (boolean) ini_get('short_open_tag'),
        ],

        [
          PhpOpenTagFormat::SHORT,
          '<?php
?><?',
          [1],
        ],
        [
          PhpOpenTagFormat::SHORT,
          '<?php echo 1',
          [1],
        ],
        [
          PhpOpenTagFormat::SHORT,
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
      if ($process === false) {
        static::markTestSkipped('PHP short open tags are not enabled.');
        return;
      }
      $tool = new OpenTagsReview($tagType);
      static::assertReview($tool, $input, $expectErrorLines);
    }

  }
