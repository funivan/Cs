<?

  namespace Funivan\Cs\Tools\Php\RedundantNullPropertyValue;

  use Funivan\PhpTokenizer\Collection;
  use Funivan\PhpTokenizer\Pattern\PatternMatcher;
  use Funivan\PhpTokenizer\Pattern\Patterns\ClassPattern;
  use Funivan\PhpTokenizer\QuerySequence\QuerySequence;
  use Funivan\PhpTokenizer\Strategy\Strict;

  /**
   *
   */
  class InvalidPropertyFinder {

    /**
     * @param Collection $collection
     * @return PropertyDefinition[]
     */
    public static function find(Collection $collection) {
      $result = [];

      (new PatternMatcher($collection))
        ->apply(new ClassPattern())
        ->apply(function (QuerySequence $q) use (&$result) {


          $q->strict((new Strict())->valueIs(['public', 'protected', 'private']));
          $q->possible(T_WHITESPACE);
          $q->possible('static');
          $q->possible(T_WHITESPACE);
          $variable = $q->strict(T_VARIABLE);

          $tokensToRemove = [];
          $tokensToRemove[] = $q->possible(T_WHITESPACE);
          $tokensToRemove[] = $q->strict('=');
          $tokensToRemove[] = $q->possible(T_WHITESPACE);
          $tokensToRemove[] = $q->strict('null');
          $tokensToRemove[] = $q->possible(T_WHITESPACE);
          $q->strict(';');

          if ($q->isValid()) {
            $result[] = new PropertyDefinition($variable, $tokensToRemove);
          }
        });

      return $result;
    }

  }