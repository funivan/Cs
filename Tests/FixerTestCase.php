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

      $file = new FileInfo($path, FileInfo::STATUS_UNKNOWN);
      $tokenizer = $file->getTokenizer();
      unlink($path);

      $this->assertNotEmpty($tokenizer);

      $tool->process($file, new Report());

      return $tokenizer->getCollection()->assemble();
    }

  }

