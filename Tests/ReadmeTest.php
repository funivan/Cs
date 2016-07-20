<?php

  namespace Tests\Funivan\Cs;

  use League\CommonMark\Block\Element\FencedCode;
  use League\CommonMark\DocParser;
  use League\CommonMark\Environment;
  use Symfony\Component\Finder\Finder;
  use Symfony\Component\Finder\SplFileInfo;
  use Webuni\CommonMark\TableExtension\TableExtension;

  /**
   *
   */
  class ReadmeTest extends BaseTestCase {

    protected static $checks = [];

    /**
     * @var DocParser
     */
    protected static $parser;


    public static function setUpBeforeClass() {

      /** @var SplFileInfo[] $directories */
      $directories = (new Finder())->in(__DIR__ . '/../src/Tools/Php')->depth(0)->directories();
      foreach ($directories as $dirInfo) {
        $fullPath = $dirInfo->getPathname();

        $baseName = '\\Funivan\\Cs\\Tools\\Php\\' . $dirInfo->getRelativePathname() . '\\' . $dirInfo->getRelativePathname();
        $readmeFilePath = $fullPath . '/README.md';
        static::$checks[$baseName] = $readmeFilePath;
      }

      parent::setUpBeforeClass();
    }


    /**
     * @param $codes
     * @param $hasFixer
     * @param $hasReview
     * @param $toolName
     */
    protected static function assertValidNumberOfCodeBlocks($codes, $hasFixer, $hasReview, $toolName) {
      $minimumNumberOfCodeBlocks = 0;

      if ($hasFixer) {
        $minimumNumberOfCodeBlocks += 2;
      }

      if ($hasReview) {
        $minimumNumberOfCodeBlocks++;
      }

      static::assertGreaterThanOrEqual($minimumNumberOfCodeBlocks, count($codes),
        'Expect at least ' . $minimumNumberOfCodeBlocks . ' code blocks. Tools: ' . $toolName);
    }


    public function testCheckReadmeSyntax() {

      foreach (static::$checks as $baseName => $checkInfo) {
        $readmeFilePath = $checkInfo;

        static::assertFileExists($readmeFilePath, 'Cant find readme file for the tool: ' . $baseName);

        $fixerClass = $baseName . 'Fixer';
        $reviewClass = $baseName . 'Review';

        spl_autoload($fixerClass);
        spl_autoload($reviewClass);

        $hasFixer = class_exists($fixerClass);
        $hasReview = class_exists($reviewClass);

        self::assertTrue(($hasFixer or $hasReview), 'Cant find fixer or review class for the tool: ' . $baseName);

        $codes = $this->getCodeBlocks($readmeFilePath);

        self::assertValidNumberOfCodeBlocks($codes, $hasFixer, $hasReview, $baseName);

        //@todo retrieve fix code examples
        if ($hasFixer) {
          $this->checkFixer($codes, $fixerClass);
        }

        //@todo retrieve review code examples
        if ($hasReview) {
          $this->checkReview($codes, $reviewClass);
        }

        //foreach ($codes as $code) {
        //  static::assertValidPhpCode($code, $baseName);
        //}

      }

    }


    /**
     * @param string $readmeFilePath
     * @return string[]
     */
    protected function getCodeBlocks($readmeFilePath) {
      $parser = static::getParser();
      $content = file_get_contents($readmeFilePath);
      $doc = $parser->parse($content);
      $walker = $doc->walker();

      $codes = [];

      do {
        $event = $walker->next();

        if ($event === null) {
          break;
        }

        $node = $event->getNode();

        if ($event->isEntering()) {
          continue;
        }

        if ($node instanceof FencedCode and $node->getInfo() === 'php') {
          $codes[] = $node->getStringContent();
        }
      } while (true);


      # prepare code
      foreach ($codes as $index => $code) {
        $code = str_replace('__DIR__', "'" . (__DIR__ . '/../') . "'", $code);
        $codes[$index] = $code;
      }

      return $codes;
    }


    /**
     * @return DocParser
     */
    protected static function getParser() {
      if (static::$parser === null) {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new TableExtension());
        static::$parser = new DocParser($environment);
      }
      return static::$parser;
    }


    /**
     * @param $codes
     * @param $fixerClass
     */
    protected function checkFixer($codes, $fixerClass) {
      $before = $codes[0];
      $after = $codes[1];

      $fixer = new $fixerClass();
      BaseTestCase::assertFixer($fixer, $before, $after);
    }


    /**
     * @param string[] $codes
     * @param string $reviewClass
     */
    protected function checkReview($codes, $reviewClass) {
      $pattern = '![/\#]\s*error lines?\s*:\s*([\d,\s]+)\n!';

      $codesToCheck = [];

      foreach ($codes as $index => $code) {
        preg_match($pattern, $code, $rawLines);
        if (empty($rawLines[1])) {
          continue;
        }

        $lines = explode(',', $rawLines[1]);

        $lines = array_map('trim', $lines);
        $lines = array_map('intval', $lines);
        $lines = array_values($lines);
        $codesToCheck[] = [
          $code,
          $lines,
        ];

      }
      self::assertGreaterThan(0, count($codesToCheck), 'Cant find any review code examples for the tool: ' . $reviewClass);

      foreach ($codesToCheck as $codeInfo) {
        $code = $codeInfo[0];
        $errorLines = $codeInfo[1];

        $tool = new $reviewClass();
        static::assertReview($tool, $code, $errorLines);
      }

    }


    /**
     * @param string $code
     * @param string $tool
     */
    protected static function assertValidPhpCode($code, $tool) {
      $path = BaseTestCase::createTempFile($code);
      $result = shell_exec('php -l ' . $path);
      $exitCode = trim(shell_exec('php ' . $path . '  > /dev/null 2>&1 && echo $?'));
      unlink($path);
      $isValid = (strpos($result, 'No syntax errors detected') === 0);
      static::assertTrue($isValid, 'Invalid code syntax:' . $code);
      static::assertEquals(0, $exitCode, 'Invalid code. Exit status ' . $exitCode . '. Tool: ' . $tool . ' Code:' . $code);
    }

  }
