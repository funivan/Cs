# Php Line before class end

## Fixer
  Add/Remove empty line/lines before class end.

  According to you configuration this fixer add or remove empty lines
  before class close. By default fixer set 1 empty line. You can change this value, see configuration.

  Name: `php_line_before_class_end_fixer`

  *Before*:
  ```<?php
      class A {
      }
  ```

  *After*:
  ```<?
      class A {

      }
  ```


## Review
  Check the number of empty lines before class closing symbol.

  Name: `php_line_before_class_end_review`



## Configuration
You can specify number of empty lines before class end.
By default we expect 1 empty line.
You can set any number from 0 to ...

```php
<?
    use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndFixer;
    use Funivan\Cs\Tools\Php\LineBeforeClassEnd\LineBeforeClassEndReview;

    //expect 2 lines
    $fixer = new LineBeforeClassEndFixer();
    $fixer->setLinesNum(2);

    $review = new LineBeforeClassEndReview();
    $review->setLinesNum(2);

    //fixer remove any empty lines
    $fixer = new LineBeforeClassEndFixer();
    $fixer->setLinesNum(0);

    $review = new LineBeforeClassEndReview();
    $review->setLinesNum(0);

```

