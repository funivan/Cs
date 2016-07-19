<?

  namespace Funivan\Cs\Tools\Php\RedundantNullPropertyValue;

  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  class PropertyDefinition {

    /**
     * @var Token
     */
    private $variable;

    /**
     * @var array
     */
    private $tokensToReplace;


    /**
     * @param Token $variable
     * @param array $tokensToReplace
     */
    public function __construct(Token $variable, array $tokensToReplace) {
      $this->variable = $variable;
      $this->tokensToReplace = $tokensToReplace;
    }


    /**
     * @return Token
     */
    public function getVariable() {
      return $this->variable;
    }


    /**
     * @return Token[]
     */
    public function getTokensToReplace() {
      return $this->tokensToReplace;
    }


  }