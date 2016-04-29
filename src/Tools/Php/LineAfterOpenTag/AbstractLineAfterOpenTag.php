<?php

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  abstract class AbstractLineAfterOpenTag implements FileTool {

    /**
     * @return string* @inheritdoc
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension('php')->isValid($file);
    }


    /**
     * @param FileInfo $file
     * @return LineTokenData[]
     */
    protected function getInvalidStartTokens(FileInfo $file) {
      $collection = $file->getTokenizer()->getCollection();

      $data = [];


      foreach ($collection as $tag) {
        if (T_OPEN_TAG !== $tag->getType()) {
          continue;
        }


        $value = $tag->getValue();
        $next = $collection->getNext();
        $whitespaceToken = null;
        if ($next->getType() === T_WHITESPACE) {
          $value = $next->getValue();
          $whitespaceToken = $next;
        }


        $num = count(explode("\n", $value));
        if ($num !== 2) {
          $data[] = new LineTokenData($num, $tag, $whitespaceToken);
        }
      }

      return $data;
    }

  }