<?php

  namespace Tests\Funivan\Cs;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  abstract class FixerTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @return FileTool
     */
    public abstract function getTool();


    /**
     * @param string $input
     * @param string $expect
     */
    public function process($input, $expect) {
      $path = tempnam(sys_get_temp_dir(), 'fix-test');
      file_put_contents($path, $input);

      $file = new FileInfo($path, FileInfo::STATUS_UNKNOWN);
      $tokenizer = $file->getTokenizer();
      unlink($path);

      $this->assertNotEmpty($tokenizer);

      $this->getTool()->process($file, new Report());


      $output = $tokenizer->getCollection()->assemble();
      $this->assertEquals($expect, $output);
    }

  }

