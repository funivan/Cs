<?php

  namespace Funivan\Cs\Console;

  use Symfony\Component\Console\Application as BaseApplication;


  /**
   * @author Ivan Scherbak <dev@funivan.com>
   */
  class Application extends BaseApplication {

    const VERSION = '0.0.1-alpha.1';

    /**
     * @var string
     */
    private $baseProjectDirectory;


    /**
     * @param string $baseProjectDirectory
     */
    public function __construct($baseProjectDirectory) {
      $this->baseProjectDirectory = $baseProjectDirectory;
      parent::__construct('PHP CS', self::VERSION);
      $this->add(new FixCommand());
      $this->add(new ReviewCommand());
    }


    /**
     * @return string
     */
    public function getLongVersion() {
      $version = parent::getLongVersion() . ' by <comment>Ivan Shcherbak</comment>';
      $commit = '@git-commit@';
      if ('@' . 'git-commit@' !== $commit) {
        $version .= ' (' . substr($commit, 0, 7) . ')';
      }
      return $version;
    }


    /**
     * @return string
     */
    public function getBaseProjectDirectory() {
      return $this->baseProjectDirectory;
    }

  }