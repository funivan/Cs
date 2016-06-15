<?php

  namespace Funivan\Cs\Review\Tools;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
  use Funivan\Cs\Report\Report;
  use Symfony\Component\Process\Process;

  /**

   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  class PhpFileStartReview implements FileTool {

    const NAME = 'php_file_start_review';


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
      return 'Check php files start tag';
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
      $cmd = sprintf('read -r LINE < %s && echo $LINE', $file->getPath());

      $process = new Process($cmd);
      $process->run();

      $firstLine = trim($process->getOutput());

      if (!in_array($firstLine, ['<?php', '<?', '#!/usr/bin/env php'])) {
        $message = 'File must begin with `<?php` or `<?` or `#!/usr/bin/env php`';
        $report->addMessage($file, $this, $message, 0);
      }
    }

  }