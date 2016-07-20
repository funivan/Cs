<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag\Tests;

  use Funivan\Cs\Tools\Php\LineAfterOpenTag\LineAfterOpenTagReview;
  use Tests\Funivan\Cs\BaseTestCase;

  /**
   *
   */
  class LineAfterOpenTagReviewTest extends BaseTestCase {

    /**
     * @return array
     */
    public function getLineAfterOpenTagDataProvider() {
      return [
        [
          '<?php



',
          [1],
        ],
        [
          '<?php

echo 1;
',
          [],
        ],
        [
          '<?php

echo 1;?>
<?


',
          [4],
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          '<?

echo 1;
',
          [],
          'process' => (boolean) ini_get('short_open_tag'),
        ],
        [
          '<?


echo 1;
',
          [1],
          'process' => (boolean) ini_get('short_open_tag'),
        ],
      ];
    }


    /**
     * @dataProvider getLineAfterOpenTagDataProvider
     * @param string $input
     * @param array $errorLines
     * @param bool $process
     */
    public function testLineAfterOpenTag($input, array $errorLines, $process = true) {
      if ($process === false) {
        static::markTestSkipped('PHP short open tags are not enabled.');
        return;
      }
      $tool = new LineAfterOpenTagReview();
      static::assertReview($tool, $input, $errorLines);
    }

  }
