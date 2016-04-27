<?php

  namespace Funivan\Cs\ToolBag\PhpOpenTagLineDelimiter;

  use Funivan\Cs\FileFinder\FileInfo;
  use Funivan\Cs\FileProcessor\CanProcessHelper;
  use Funivan\Cs\FileProcessor\FileTool;

  /**
   *
   */
  abstract class LineAfterOpenTag implements FileTool {

    /**
     * @return string* @inheritdoc
     */
    public function canProcess(FileInfo $file) {
      return (new CanProcessHelper())->notDeleted()->extension('php')->isValid($file);
    }


    /**
     * @param FileInfo $file
     * @return array Array<Array<Int, Token>>
     */
    protected function getInvalidStartTokens(FileInfo $file) {
      $collection = $file->getTokenizer()->getCollection();

      $tokens = [];


      foreach ($collection as $tag) {
        if (T_OPEN_TAG !== $tag->getType()) {
          continue;
        }

        if ($tag->getValue() === '<?') {
          $emptyLines = explode("\n", $collection->getNext()->getValue());
        } else {
          $emptyLines = explode("\n", $tag->getValue());
        }

        $num = count($emptyLines);
        if ($num <= 2) {
          $tokens[] = [$num, $tag];
        }
      }

      return $tokens;
    }

  }