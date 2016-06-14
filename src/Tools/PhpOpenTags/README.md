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
    use Funivan\Cs\Tools\PhpOpenTags;

    // Configure fixer
    new PhpOpenTagsFactory(
        PhpOpenTagsFactory::TAG_FORMAT_LONG, // specify tag format
        PhpOpenTagsFactory::FIXER // specify whitch tool do you want to use
    );

    // Configure review
    new PhpOpenTagsFactory(
            PhpOpenTagsFactory::TAG_FORMAT_LONG,
            PhpOpenTagsFactory::REVIEW
    );


```

