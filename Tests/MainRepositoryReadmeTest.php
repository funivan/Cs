<?php

  namespace Tests\Funivan\Cs;

  /**
   *
   */
  class MainRepositoryReadmeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return string
     */
    private function getReadmeContent() {
      return file_get_contents(__DIR__ . '/../README.md');
    }


    public function testCheckFilePath() {
      $content = $this->getReadmeContent();
      preg_match_all("!(src.+\.md)!", $content, $rawFiles);
      $filesList = !empty($rawFiles[0]) ? $rawFiles[0] : [];
      static::assertNotEmpty($filesList);

      $baseDir = __DIR__ . '/..';
      foreach ($filesList as $partialFilePath) {
        $path = $baseDir . '/' . $partialFilePath;
        static::assertFileExists($path);
      }

    }

  }
