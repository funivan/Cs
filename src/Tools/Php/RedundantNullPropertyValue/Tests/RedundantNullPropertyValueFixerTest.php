<?php

  namespace Funivan\Cs\Tools\Php\RedundantNullPropertyValue\Tests;

  use Funivan\Cs\Tools\Php\RedundantNullPropertyValue\RedundantNullPropertyValueFixer;
  use Tests\Funivan\Cs\FixerTestCase;


  /**
   *
   */
  class RedundantNullPropertyValueFixerTest extends FixerTestCase {

    /**
     * @return array
     */
    public function getReplaceRedundantNullValuesDataProvider() {
      return [
        [
          '<?php class A {protected static $b =null;}',
          '<?php class A {protected static $b;}',
        ],
        [
          '<?php class A {public   static $d= null ;}',
          '<?php class A {public   static $d;}',
        ],
        [
          '<?php class A {public $a=null;}',
          '<?php class A {public $a;}',
        ],
        [
          '<?php class A {protected $b =null;}',
          '<?php class A {protected $b;}',
        ],
        [
          '<?php class A {private $b =null;}',
          '<?php class A {private $b;}',
        ],
        [
          '<?php echo 1;',
          '<?php echo 1;',
        ],
        [
          '<?php class A {}',
          '<?php class A {}',
        ],
        [
          '<?php class A {public $a=1;}',
          '<?php class A {public $a=1;}',
        ],
        [
          '<?php class A {public $a=null;}',
          '<?php class A {public $a;}',
        ],
        [
          '<?php class A {
          public $a=null ;
          }
          ',
          '<?php class A {
          public $a;
          }
          ',
        ],

      ];
    }


    /**
     * @dataProvider getReplaceRedundantNullValuesDataProvider
     * @param string $input
     * @param string $expect
     */
    public function testReplaceRedundantNullValues($input, $expect) {
      $output = $this->convert(new RedundantNullPropertyValueFixer(), $input);
      static::assertEquals($expect, $output);
    }

  }
