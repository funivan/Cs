<?php

  namespace Funivan\Cs\Tools\Php\ReturnTypeFormat;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
  use Funivan\Cs\Report\Report;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Pattern\Pattern;
  use Funivan\PhpTokenizer\QuerySequence\QuerySequence;
  use Funivan\PhpTokenizer\Strategy\Search;
  use Funivan\PhpTokenizer\Strategy\Strict;

  /**
   *
   */
  class ReturnTypeFormatFixer implements FileTool {

    /**
     * @var string
     */
    private $before = " ";

    /**
     * @var string
     */
    private $after = " ";


    /**
     * Return unique string of the tool
     * You can set any name but we suggest to use following rules:
     *  - Allowed chars [a-z0-9_]+
     *  - Review tools should have ending `_review`
     *  - Fixer tools should have ending `_fixer`
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getName() {
      return 'php_return_type_format_fixer';
    }


    /**
     * @return string
     */
    public function getDescription() {
      return 'Reformat php return type declaration';
    }


    /**
     * Check if we can process file by this tool
     * Called before file process
     *
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file) {
      return (new FileFilter())->extension(['php'])->isValid($file);
    }


    /**
     * @param File $file
     * @param Report $report
     */
    public function process(File $file, Report $report) {
      $collection = Collection::createFromString($file->getContent()->get());

      (new Pattern($collection))->apply(function (QuerySequence $q) {
        $any = Strict::create()->valueLike('!.+!');

        $q->strict('function');
        $q->strict(T_WHITESPACE);
        $q->strict($any);
        $q->possible(T_WHITESPACE);
        $q->section('(', ')');

        // return type
        $beforeSpace = $q->possible(T_WHITESPACE);
        $identifier = $q->strict(':');
        $afterSpace = $q->possible(T_WHITESPACE);
        $q->strict($any);
        $q->search(Search::create()->valueLike('!^\{|\;$!'));

        if ($q->isValid()) {
          $beforeSpace->remove();
          $identifier->prependToValue($this->before); // add symbol before
          $identifier->appendToValue($this->after); // add symbol after
          $afterSpace->remove();
        }
      });

      $file->getContent()->set((string) $collection);
    }


    /**
     * @return string
     */
    public function getBefore() {
      return $this->before;
    }


    /**
     * @param string $before
     * @return $this
     */
    public function setBefore($before) {
      $this->before = $before;
      return $this;
    }


    /**
     * @return string
     */
    public function getAfter() {
      return $this->after;
    }


    /**
     * @param string $after
     * @return $this
     */
    public function setAfter($after) {
      $this->after = $after;
      return $this;
    }

  }