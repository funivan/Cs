<?php

  namespace Funivan\Cs\Console;

  use Funivan\Cs\Configuration\ConfigurationInterface;
  use Funivan\Cs\FileFinder\FinderParams;
  use Funivan\Cs\FileProcessor\ToolsFilter;
  use Funivan\Cs\Fixer\FixerProcessor;
  use Funivan\Cs\Message\Report;
  use Symfony\Component\Console\Command\Command;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Logger\ConsoleLogger;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   *
   */
  abstract class BaseCommand extends Command {

    /**
     * @inheritDoc
     */
    protected function configure() {

      $this->addOption('configuration', null, InputOption::VALUE_REQUIRED, 'Path to the configuration file');

      $this->addOption('directory', null, InputOption::VALUE_REQUIRED, 'Process files inside this directory', null);
      $this->addOption('commit', null, InputOption::VALUE_REQUIRED, 'Process files changed in specific commit. By default we check all modified files', null);
      $this->addOption('tools', null, InputOption::VALUE_REQUIRED, 'Filter tools by name');

      $this->addOption('list-tools', null, InputOption::VALUE_NONE, 'Show Tools that will be applied to the files');

      parent::configure();
    }


    /**
     * @inheritdoc
     */
    protected final function execute(InputInterface $input, OutputInterface $output) {


      $configuration = $input->getOption('configuration');

      if (!empty($configuration)) {
        /** @noinspection PhpIncludeInspection */
        /** @var ConfigurationInterface $config */
        $config = include_once $configuration;
      } else {
        $config = $this->getDefaultConfiguration();
      }

      if (empty($config)) {
        $output->writeln('<error>Provide valid configuration file path</error>');
        return 0;
      }

      if (!($config instanceof ConfigurationInterface)) {
        throw new \Exception('Invalid configuration file result. Expect ' . ConfigurationInterface::class);
      }

      $tools = $config->getToolsConfiguration();


      $fixerNames = explode(',', $input->getOption('tools'));
      $fixerNames = array_filter($fixerNames);
      $fixTools = (new ToolsFilter($tools))->filterTools($fixerNames);

      if ($input->getOption('list-tools')) {
        foreach ($fixTools as $toolConfig) {
          $output->writeln('Tool : ' . $toolConfig->getName());
        }
        return 0;
      }

      $fileProcessor = $this->getFileProcessor($input, $output);
      foreach ($fixTools as $toolConfig) {
        $fileProcessor->addTool($toolConfig->createTool());
        $output->writeln('Add tool: ' . $toolConfig->getName(), OutputInterface::VERBOSITY_VERY_VERBOSE);
      }

      $fileProcessor->setOutput($output);

      $params = new FinderParams();
      $params->setDirectory($input->getOption('directory'));
      $params->setCommit($input->getOption('commit'));
      $files = $config->getFileFinderFactory($params)->getFiles();


      if ($files->count() === 0) {
        $output->writeln('<comment>✔ Empty files list</comment>');
        return 0;
      }

      $report = new Report();

      $fileProcessor->process($files, $report);

      return $this->getResultState($input, $output, $report);
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return FixerProcessor
     */
    protected abstract function getFileProcessor(InputInterface $input, OutputInterface $output);


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Report $report
     * @return int
     */
    protected abstract function getResultState(InputInterface $input, OutputInterface $output, Report $report);


    /**
     * @return ConfigurationInterface
     */
    protected abstract function getDefaultConfiguration() ;

  }