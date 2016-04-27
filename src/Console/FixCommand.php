<?php

  namespace Funivan\Cs\Console;

  use Funivan\Cs\Configuration\ConfigurationInterface;
  use Funivan\Cs\Fixer\FixerProcessor;
  use Funivan\Cs\Message\Report;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * This part of code will be exported to the external library.
   */
  class FixCommand extends BaseCommand {

    /**
     * @inheritdoc
     */
    protected function configure() {
      $this->setName('fix');

      $this->setDescription('Fix code according your code style');
      $this->addOption('save', null, InputOption::VALUE_NONE, 'By default we will show info without code modification');
      parent::configure();
    }


    /**
     * @inheritdoc
     */
    protected function getResultState(InputInterface $input, OutputInterface $output, Report $report) {
      $isVerbose = ($output->getVerbosity() === OutputInterface::VERBOSITY_DEBUG);

      if ($report->count() === 0) {
        $output->writeln('<info>✔ Looking good</info>');
        return 0;
      }

      $output->writeln('');

      foreach ($report as $message) {
        $output->write('<info>');
        $output->writeln('file    : ' . $message->getFile()->getPath() . ':' . $message->getLine());
        $output->writeln('toolConfig    : ' . $message->getToolName());
        if ($isVerbose) {
          $output->writeln('info    : ' . $message->getTool()->getDescription());
        }

        $output->writeln('message : ' . $message->getText());
        $output->writeln('</info>');
      }

      if ($input->getOption('save')) {
        $output->writeln('<info>✔ Fixed</info>');
      } else {
        $output->writeln('<comment>✔ Dry run</comment>');
      }
      return 0;
    }


    /**
     * @inheritdoc
     */
    protected function getFileProcessor(InputInterface $input, OutputInterface $output) {
      $fixer = new FixerProcessor();
      $fixer->setSaveFiles($input->getOption('save'));
      return $fixer;
    }


    /**
     * @return ConfigurationInterface
     */
    protected function getDefaultConfiguration() {
      /** @var \Funivan\Cs\Console\Application $app */
      $app = $this->getApplication();

      $configuration = \Funivan\Cs\Configuration\CsConfiguration::createFixerConfiguration();
      $configuration->setFileFinderFactory(new \Funivan\Cs\FileFinder\FinderFactory\FileFinderFactory($app->getBaseProjectDirectory()));

      return $configuration;
    }

  }
