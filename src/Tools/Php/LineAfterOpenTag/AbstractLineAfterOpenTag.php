<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Fs\File;
  use Funivan\Cs\Fs\FileFilter;
  use Funivan\PhpTokenizer\Collection;

  /**
   *
   */
  abstract class AbstractLineAfterOpenTag implements FileTool {

    /**
     * @return string* @inheritdoc
     */
    public function canProcess(File $file) {
      return (new FileFilter())->notDeleted()->extension(['php'])->isValid($file);
    }


    /**
     * @param Collection $collection
     * @return LineTokenData[]
     */
    protected function getInvalidStartTokens(Collection $collection) {


      $data = [];


      foreach ($collection as $tag) {
        if (T_OPEN_TAG !== $tag->getType()) {
          continue;
        }


        $value = $tag->getValue();
        $next = $collection->getNext();
        $whitespaceToken = null;
        if ($next->getType() === T_WHITESPACE) {
          $value = $value . $next->getValue();
          $whitespaceToken = $next;
        }


        $num = count(explode("\n", $value));
        if ($num !== 3) {
          $data[] = new LineTokenData($num, $tag, $whitespaceToken);
        }

      }

      return $data;
    }

  }