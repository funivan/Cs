<?php

  namespace Funivan\Cs\Tools\Php\ReturnTypeFormat\Tests;

  use Funivan\Cs\Tools\Php\ReturnTypeFormat\ReturnTypeFormatFixer;
  use Tests\Funivan\Cs\FixerTestCase;


  /**
   *
   */
  class ReturnTypeFormatFixerTest extends FixerTestCase {

    /**
     * @var bool
     */
    private static $isAvailable = true;


    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass() {
      parent::setUpBeforeClass();
      self::$isAvailable = (boolean) version_compare(phpversion(), '7.0.0', '>=');
    }


    /**
     * @return array
     */
    public function getReturnTypeDataProvider() {
      return [
        [
          '<?php function a(){}',
          '<?php function a(){}',
          [],
        ],
        [
          '<?php function a():int{}',
          '<?php function a():int{}',
          ['', ''],
        ],
        [
          '<?php function a():int{}',
          '<?php function a() :int{}',
          [' ', ''],
        ],
        [
          '<?php function a():int{}',
          '<?php function a()
:    int{}',
          ["\n", "    "],
        ],
        [
          '<?php function a():user{}',
          '<?php function a() : user{}',
          [],
        ],

        [
          '<?php function a() :\user{}',
          '<?php function a() : \user{}',
          [],
        ],

        [
          '<?php function a() :user
          {}',
          '<?php function a() : user
          {}',
          [],
        ],
        [
          '<?php class B{ abstract function a() :user ;',
          '<?php class B{ abstract function a() : user ;',
          [],
        ],
        [
          '<?php class B{ abstract function a():   
           \df\customuser ;',
          '<?php class B{ abstract function a() : \df\customuser ;',
          [],
        ],
      ];
    }


    /**
     * @dataProvider getReturnTypeDataProvider
     */
    public function testReturn($input, $expect, array $delimiters = []) {
      if (self::$isAvailable === false) {
        $this->markTestSkipped('Tests can only be run on php 7.0 or greater');
        return;
      }

      $fixer = new ReturnTypeFormatFixer();
      if (isset($delimiters[0])) {
        $fixer->setBefore($delimiters[0]);
      }

      if (isset($delimiters[1])) {
        $fixer->setAfter($delimiters[1]);
      }

      $this->process($fixer, $input, $expect);
    }

  }
