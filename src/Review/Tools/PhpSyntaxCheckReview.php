<?php

  namespace Funivan\Cs\Review\Tools;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;
  use Funivan\Cs\Message\Report;
  use Symfony\Component\Process\Process;

  /**
   
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpSyntaxCheckReview implements FileTool {

    const NAME = 'php_syntax_check_review';


    /**
     * @inheritdoc
     */
    public function getName() {
      return self::NAME;
    }


    /**
     * @inheritdoc
     */
    public function getDescription() {
      return 'Check php and html files syntax using standard php lint tool';
    }


    /**
     * @inheritdoc
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension(['php', 'phtml', 'html'])->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $cmd = sprintf('php --syntax-check %s', $file->getPath());

      $process = new Process($cmd);
      $process->run();

      # Create the array of outputs and remove empty values.
      $output = array_filter(explode(PHP_EOL, $process->getOutput()));

      if ($process->isSuccessful()) {
        return;
      }

      $regex = '!\s+on line (\d+)!';

      $needle = 'Parse error: syntax error, ';
      foreach (array_slice($output, 0, count($output) - 1) as $error) {
        $raw = ucfirst(substr($error, strlen($needle)));
        $message = str_replace(' in ' . $file->getPath(), '', $raw);

        $line = 0;
        preg_match($regex, $message, $lineMatch);
        if (isset($lineMatch[1])) {
          $line = (int) $lineMatch[1];
          $message = preg_replace($regex, '', $message);
        }

        $report->addError($file, $this, $message, $line);
      }

    }

  }