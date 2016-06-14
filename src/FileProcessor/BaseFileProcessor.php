<?php

  namespace Funivan\Cs\FileProcessor;

  use Funivan\Cs\FileTool\FileTool;
  use Symfony\Component\Console\Output\NullOutput;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2016
   */
  abstract class BaseFileProcessor implements FileProcessorInterface {

    /**
     * @var FileTool[]
     */
    private $tools = [];

    /**
     * @var OutputInterface
     */
    private $output;


    /**
     * @param FileTool $tool
     */
    public function addTool(FileTool $tool) {
      $this->tools[] = $tool;
    }


    /**
     * @return FileTool[]
     */
    public function getTools() {
      return $this->tools;
    }


    /**
     * Sets a logger.
     *
     * @param OutputInterface $logger
     */
    public function setOutput(OutputInterface $logger) {
      $this->output = $logger;
    }


    /**
     * @return OutputInterface
     */
    public function getOutput() {
      if (null === $this->output) {
        $this->output = new NullOutput();
      }

      return $this->output;
    }

  }