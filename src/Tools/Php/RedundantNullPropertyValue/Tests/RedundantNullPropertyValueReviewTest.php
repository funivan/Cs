<?php

  namespace Funivan\Cs\Tools\Php\RedundantNullPropertyValue\Tests;

  use Funivan\Cs\Tools\Php\RedundantNullPropertyValue\RedundantNullPropertyValueReview;


  /**
   *
   */
  class RedundantNullPropertyValueReviewTest extends \Tests\Funivan\Cs\BaseTestCase {

    /**
     * @return array
     */
    public function getCheckDataProvider() {
      return [
        [
          '<?php
          class A {protected $a=1;}
          class B {protected static $bd=4;}
          ',
          [],
        ],
        [
          '<?php
          class A {protected $a=null;}
          class B {protected static $bd=null;}
          ',
          [2, 3],
        ],
        [
          '<?php
          class A {public $a = null;}
          class B {public static $bd = null;}
          ',
          [2, 3],
        ],
        [
          '<?php
          class A {public $a = [];}',
          [],
        ],
      ];
    }


    /**
     * @dataProvider getCheckDataProvider
     * @param string $input
     * @param array $expectErrorLines
     * @throws \Exception
     */
    public function testCheck($input, array $expectErrorLines) {
      $tool = new RedundantNullPropertyValueReview();
      static::assertReview($tool, $input, $expectErrorLines);

    }

  }
