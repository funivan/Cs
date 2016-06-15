<?php

  namespace Tests\Funivan\Cs;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

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

      $report = new Report();
      try {

        $file = new File($path, File::STATUS_UNKNOWN);
        self::assertNotEmpty($file->getContent()->get());

        $tool->process($file, $report);

        $output = $file->getContent()->get();

        $this->assertEquals($input, $output, 'Review should not change source code. Tool:' . $tool->getName());
      } catch (\Exception $e) {
        throw $e;
      } finally {
        @unlink($path);
      }


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
