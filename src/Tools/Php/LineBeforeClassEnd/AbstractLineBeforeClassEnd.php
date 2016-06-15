<?php

  namespace Funivan\Cs\Tools\Php\LineBeforeClassEnd;

  use Funivan\Cs\FileTool\FileTool;
  use Funivan\Cs\Filters\FileFilter;
  use Funivan\Cs\Fs\File;
  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Pattern\Pattern;
  use Funivan\PhpTokenizer\Pattern\Patterns\ClassPattern;
  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  abstract class AbstractLineBeforeClassEnd implements FileTool {

    /**
     * @var int
     */
    private $linesNum = 1;


    /**
     * @param File $file
     * @return boolean
     */
    public function canProcess(File $file) {
      return (new FileFilter())->extension('php')->notDeleted()->isValid($file);
    }


    /**
     * @param int $linesNum
     * @return $this
     */
    public function setLinesNum($linesNum) {
      if (!is_int($linesNum) or $linesNum < 0) {
        throw new \InvalidArgumentException('Expect positive lines num');
      }
      $this->linesNum = $linesNum;
      return $this;
    }


    /**
     * @return int
     */
    public function getLinesNum() {
      return $this->linesNum;
    }


    /**
     * @param Collection $collection
     * @return Collection
     */
    protected function getInvalidTokens(Collection $collection) {

      $resultCollection = new Collection();
      $classBody = (new Pattern($collection))->apply((new ClassPattern()))->getCollections();
      if (empty($classBody)) {
        return $resultCollection;
      }

      foreach ($classBody as $body) {
        if ($body->count() === 0) {
          continue;
        }

        $resultCollection->append($body->getLast());
      }


      foreach ($resultCollection as $index => $token) {
        if ($this->isValidBodyEndToken($token)) {
          $resultCollection->offsetUnset($index);
        }
      }

      $resultCollection->rewind();

      return $resultCollection;
    }


    /**
     * @param Token $token
     * @return bool
     */
    protected function isValidBodyEndToken(Token $token) {
      if (T_WHITESPACE !== $token->getType()) {
        return false;
      }

      if ($this->linesNum === 0 and strpos($token->getValue(), "\n") === false) {
        return true;
      }

      return ($this->linesNum === (count(explode("\n", $token->getValue())) - 2));
    }

  }