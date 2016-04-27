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
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension('php')->isValid($file);
    }


    /**
     * @inheritdoc
     */
    public function process(FileInfo $file, Report $report) {
      $cmd = sprintf('read -r LINE < %s && echo $LINE', $file->getPath());

      $process = new Process($cmd);
      $process->run();

      $firstLine = trim($process->getOutput());

      if (!in_array($firstLine, ['<?php', '<?', '#!/usr/bin/env php'])) {
        $message = 'File must begin with `<?php` or `<?php` or `#!/usr/bin/env php`';
        $report->addError($file, $this, $message, 0);
      }
    }

  }