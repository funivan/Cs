<?php

  namespace Tests\Funivan\Cs;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Message\Report;

  /**
   *
   */
  abstract class ReviewTestCase extends \PHPUnit_Framework_TestCase {


    /**
     * @param FileTool $tool
     * @param string $input
     * @return Report
     */
    protected function process(FileTool $tool, $input) {
      $path = tempnam(sys_get_temp_dir(), 'review-test');
      file_put_contents($path, $input);

      $file = new FileInfo($path, FileInfo::STATUS_UNKNOWN);
      $tokenizer = $file->getTokenizer();
      unlink($path);

      $this->assertNotEmpty($tokenizer);

      $report = new Report();
      $tool->process($file, $report);


      $output = $tokenizer->getCollection()->assemble();

      $this->assertEquals($input, $output, 'Review should not change source code. Tool:' . $tool->getName());

      return $report;
    }


    /**
     * @param Report $report
     * @param array $expectErrorLines
     */
    protected function assertInvalidLinesInReport(Report $report, array $expectErrorLines) {
      $errorLines = [];
      foreach ($report as $message) {
        $errorLines[] = $message->getLine();
      }

      $this->assertEquals($expectErrorLines, $errorLines);
    }

  }
