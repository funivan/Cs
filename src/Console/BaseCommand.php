<?php

  namespace Funivan\Cs\Console;

  use Funivan\Cs\Configuration\ConfigurationInterface;
  use Funivan\Cs\FileProcessor\BaseFileProcessor;
  use Funivan\Cs\FileProcessor\FileProcessorInterface;
  use Funivan\Cs\FileTool\ToolsFilter;
  use Funivan\Cs\Fs\FileFinder\FinderParameters;
  use Funivan\Cs\Report\Report;
  use Symfony\Component\Console\Command\Command;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  abstract class BaseCommand extends Command {

    /**
     * @inheritDoc
     */
    protected function configure() {

      $this->addOption('configuration', null, InputOption::VALUE_REQUIRED, 'Path to the configuration file', null);

      $this->addOption('finder-parameter', null, InputOption::VALUE_IS_ARRAY ^ InputOption::VALUE_REQUIRED, 'Provide custom parameters fot the file finder', []);

      $this->addOption('filter-tools', null, InputOption::VALUE_IS_ARRAY ^ InputOption::VALUE_REQUIRED, 'Filter tools by name', []);

      #
      $this->addOption('list-tools', null, InputOption::VALUE_NONE, 'Show Tools that will be applied to the files');
      $this->addOption('list-all-tools', null, InputOption::VALUE_NONE, 'Show All Tools that can be used');


      parent::configure();
    }


    /**
     * @inheritdoc
     */
    protected final function execute(InputInterface $input, OutputInterface $output) {

      $config = $this->createConfiguration($input->getOption('configuration'));

      $tools = $config->getTools();

      # list all tools
      if ($input->getOption('list-all-tools')) {
        foreach ($tools as $tool) {
          $output->writeln('Tool : ' . $tool->getName());
        }
        return 0;
      }

      $toolsFilter = $this->createToolsFilter($input->getOption('filter-tools'));

      foreach ($tools as $index => $tool) {
        if (!$toolsFilter->isValid($tool)) {
          unset($tools[$index]);
        }
      }

      # list tools
      if ($input->getOption('list-tools')) {
        foreach ($tools as $tool) {
          $output->writeln('Tool : ' . $tool->getName());
        }
        return 0;
      }

      $fileProcessor = $this->getFileProcessor($input, $output);
      foreach ($tools as $tool) {
        $fileProcessor->addTool($tool);
        $output->writeln('Add tool: ' . $tool->getName(), OutputInterface::VERBOSITY_VERY_VERBOSE);
      }

      if ($fileProcessor instanceof BaseFileProcessor) {
        $fileProcessor->setOutput($output);
      }


      $parameters = $input->getOption('finder-parameter');
      $finderParameters = $this->createFinderParameters($parameters);

      $files = $config->getFilesFinder()->findFiles($finderParameters);


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
     * @return FileProcessorInterface
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
    protected abstract function getDefaultConfiguration();


    /**
     * @param array $rawParameters
     * @return FinderParameters
     */
    private function createFinderParameters(array $rawParameters) {
      $finderParameters = new FinderParameters();

      /** @var Application $app */
      $app = $this->getApplication();

      $finderParameters->set('baseDir', $app->getBaseProjectDirectory());
      foreach ($rawParameters as $paramInfo) {
        $finderParameter = explode(':', $paramInfo);
        if (count($finderParameter) !== 2) {
          throw new \InvalidArgumentException('Invalid params format. Expect 2 values');
        }
        $finderParameters->set($finderParameter[0], $finderParameter[1]);
      }

      return $finderParameters;
    }


    /**
     * @param string|null $configurationFilePath
     * @return ConfigurationInterface
     * @throws \Exception
     */
    protected function createConfiguration($configurationFilePath) {
      if ($configurationFilePath === null) {
        return $this->getDefaultConfiguration();
      }

      /** @noinspection PhpIncludeInspection */
      /** @var ConfigurationInterface $config */
      $config = include_once $configurationFilePath;

      if (empty($config)) {
        throw new \Exception('Provide valid configuration file path');
      }

      if (!($config instanceof ConfigurationInterface)) {
        throw new \Exception('Invalid configuration file result. Expect ' . ConfigurationInterface::class);
      }

      return $config;
    }


    /**
     * @param string[] $filters
     * @return ToolsFilter
     */
    protected function createToolsFilter(array $filters) {

      $include = null;
      $exclude = null;


      $fixerNames = explode(',', implode(',', $filters));
      $fixerNames = array_map('trim', $fixerNames);
      $fixerNames = array_filter($fixerNames);

      foreach ($fixerNames as $name) {
        if (strpos($name, '-') === 0) {
          $exclude[] = (string) substr($name, 1);
        } else {
          $include[] = (string) $name;
        }
      }


      $toolsFilter = new ToolsFilter();
      $toolsFilter->setExclude($exclude);
      $toolsFilter->setInclude($include);

      return $toolsFilter;
    }

  }