<?php

  namespace Funivan\Cs\Tools\Php\FileStartLine;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
  use Funivan\Cs\Report\Report;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpFileStartLineReview implements FileTool {

    const NAME = 'php_file_start_line_review';

    const REGEXP = [
      '~^<\?php(\s+|$)~',
      '~^<\?(\s+|$)~',
      '~#!/usr/bin/env php(\s+|$)~',
    ];


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
      return 'Check php files first line';
    }


    /**
     * @inheritdoc
     */
    public function canProcess(File $file) {
      return (new FileFilter())->notDeleted()->extension(['php'])->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(File $file, Report $report) {
      $fileContent = $file->getContent()->get();

      foreach (self::REGEXP as $regexp) {
        if (preg_match($regexp, $fileContent) === 1) {
          return;
        }
      }

      $message = 'File must begin with `<?php` or `<?` or `#!/usr/bin/env php`';
      $report->addMessage($file, $this, $message, 1);

    }

  }