<?php

  namespace Tests\Funivan\Cs;

  use Funivan\Cs\FileFinder\File;
  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Report\Report;

  /**
   *
   */
  abstract class FixerTestCase extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {
      parent::setUpBeforeClass();
      ini_set('short_open_tag', true);
    }


    /**
     * @param FileTool $tool
     * @param string $input
     * @param string $expect
     */
    public function process(FileTool $tool, $input, $expect) {
      $output = $this->convert($tool, $input);
      $this->assertEquals($expect, $output);
    }


    /**
     * @param FileTool $tool
     * @param string $input
     * @return string
     */
    protected function convert(FileTool $tool, $input) {
      $path = tempnam(sys_get_temp_dir(), 'fix-test');
      file_put_contents($path, $input);

      $file = new File($path, File::STATUS_UNKNOWN);
      self::assertNotEmpty($file->getContent()->get());
      unlink($path); // content is loaded, we can delete source file

      $tool->process($file, new Report());

      return $file->getContent()->get();
    }

  }

