# Php Open Tags format

## Fixer
  Replace invalid line endings

  Name: `php_open_tags_fixer`

  *Before*:
  ```<?php
        echo 1
  ```

  *After*:
  ```<?
        echo 1;
  ```


## Review
  Find files with invalid open tags format

  Name: `php_open_tags_review`



## Configuration
You can configure type of php tags that you want to use.
There are 2 types of tags:
    - long `<?php`
    - short `<?`

With configuration class `PhpOpenTagsFactory` you can configure `review` and `fixer`

```php
<?php

    use Funivan\Cs\Tools\PhpOpenTags;

    // Configure fixer and review to check use only long php tags (<?php)
    new PhpOpenTags\PhpOpenTagsFixer(PhpOpenTags\PhpOpenTagFormat::LONG);
    new PhpOpenTags\PhpOpenTagsReview(PhpOpenTags\PhpOpenTagFormat::LONG);

    // Configure fixer and review to check use only short php tags (<?)

    new PhpOpenTags\PhpOpenTagsFixer(PhpOpenTags\PhpOpenTagFormat::SHORT);
    new PhpOpenTags\PhpOpenTagsReview(PhpOpenTags\PhpOpenTagFormat::SHORT);


```

