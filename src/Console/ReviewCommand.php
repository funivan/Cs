<?php

  namespace Funivan\Cs\Console;

  use Funivan\Cs\Configuration\ConfigurationInterface;
  use Funivan\Cs\Configuration\CsConfiguration;
  use Funivan\Cs\FileFinder\FinderFactory\FileFinderFactory;
  use Funivan\Cs\Message\FileMessage;
  use Funivan\Cs\Message\Report;
  use Funivan\Cs\Review\ReviewFileProcessor;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   *
   */
  class ReviewCommand extends BaseCommand {

    /**
     * @inheritdoc
     */
    protected function configure() {
      $this->setName('review');
      $this->setDescription('Review source code according to your code style');
      parent::configure();
    }


    /**
     * @inheritdoc
     */
    protected function getFileProcessor(InputInterface $input, OutputInterface $output) {
      return new ReviewFileProcessor();
    }


    /**
     * @inheritdoc
     */
    protected function getResultState(InputInterface $input, OutputInterface $output, Report $report) {
      // show errors

      $isVerbose = ($output->getVerbosity() === OutputInterface::VERBOSITY_DEBUG);

      $output->writeln('');

      $hasCriticalError = false;

      $errorsNum = 0;
      foreach ($report as $message) {
        $errorsNum++;
        if ($message->getLevel() === FileMessage::LEVEL_ERROR) {
          $hasCriticalError = true;
        }

        $output->write('<error>');
        $output->writeln('level   : ' . $message->getLevelName());
        $output->writeln('file    : ' . $message->getFile()->getPath() . ':' . $message->getLine());
        if ($isVerbose) {
          $output->writeln('tool    : ' . $message->getToolName());
          $output->writeln('info    : ' . $message->getTool()->getDescription());
        }

        $output->writeln('message : ' . $message->getText());
        $output->writeln('</error>');
      }

      if ($errorsNum === 0) {
        $output->writeln('<info>✔ Looking good</info>');
        return 0;
      }

      if ($hasCriticalError) {
        $output->writeln('<error>✘ Please fix the errors above. Errors num: ' . $errorsNum . '</error>');
        return 1;
      }

      $output->writeln('<error>✘ Take a look. There are some notices.  Notices num: ' . $errorsNum . '</error>');
      return 0;
    }


    /**
     * @return ConfigurationInterface
     */
    protected function getDefaultConfiguration() {
      /** @var \Funivan\Cs\Console\Application $app */
      $app = $this->getApplication();

      $configuration = CsConfiguration::createReviewConfiguration();
      $configuration->setFileFinderFactory(new FileFinderFactory($app->getBaseProjectDirectory()));

      return $configuration;
    }

  }
