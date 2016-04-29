<?

  namespace Funivan\Cs\Tools\Php\LineAfterOpenTag;

  use Funivan\PhpTokenizer\Token;

  /**
   *
   */
  class LineTokenData {

    /**
     * @var int
     */
    private $linesNum;

    /**
     * @var Token
     */
    private $token;

    /**
     * @var Token
     */
    private $whitespace;


    /**
     * @param int $linesNum
     * @param Token $token
     * @param Token $whitespace
     */
    public function __construct($linesNum, Token $token, Token $whitespace = null) {
      $this->linesNum = $linesNum;
      $this->token = $token;
      $this->whitespace = $whitespace ? $whitespace : new Token();
    }


    /**
     * @return int
     */
    public function getLinesNum() {
      return $this->linesNum;
    }


    /**
     * @return Token
     */
    public function getToken() {
      return $this->token;
    }


    /**
     * @return Token
     */
    public function getWhitespace() {
      return $this->whitespace;
    }

  }