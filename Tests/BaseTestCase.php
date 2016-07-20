<?php

  namespace Tests\Funivan\Cs;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Report\Report;

  /**
   *
   */
  abstract class BaseTestCase extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {
      parent::setUpBeforeClass();
      ini_set('short_open_tag', true);
    }


    /**
     * @param FileTool $tool
     * @param string $input
     * @param array $errorLines
     * @throws \Exception
     */
    public static function assertReview(FileTool $tool, $input, array $errorLines) {
      $path = tempnam(sys_get_temp_dir(), 'review-test');
      file_put_contents($path, $input);

      $report = new Report();
      try {

        $file = new File($path, File::STATUS_UNKNOWN);
        self::assertNotEmpty($file->getContent()->get());

        $tool->process($file, $report);

        $output = $file->getContent()->get();

        self::assertEquals($input, $output, 'Review should not change source code. Tool:' . $tool->getName());
      } catch (\Exception $e) {
        throw $e;
      } finally {
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        @unlink($path);
      }


      $reportErrorLines = [];
      foreach ($report as $message) {
        $reportErrorLines[] = $message->getLine();
      }

      self::assertEquals($reportErrorLines, $errorLines, 'Invalid error lines. Tool: ' . $tool->getName());
    }


    /**
     * @param FileTool $tool
     * @param string $input
     * @param string $expect
     */
    public static function assertFixer(FileTool $tool, $input, $expect) {
      $path = BaseTestCase::createTempFile($input);

      $file = new File($path, File::STATUS_UNKNOWN);
      self::assertNotEmpty($file->getContent()->get());
      # content is loaded, we can delete source file
      unlink($path);

      $tool->process($file, new Report());

      $output = $file->getContent()->get();

      static::assertEquals($expect, $output);
    }


    /**
     * @param string $input
     * @return string
     */
    public static function createTempFile($input) {
      $path = tempnam(sys_get_temp_dir(), 'fix-test');
      file_put_contents($path, $input);
      return $path;
    }

  }
