# Php Open Tags Format

## Fixer

  Always use same php open tags format.
  By default short tags are replaced to the long tags.

  Name: `php_open_tags_fixer`

  *Before*:
  ```php
  <?
        echo 1;
  ```

  *After*:
  ```php
  <?php
        echo 1;
  ```


## Review
  Find files with invalid open tags format

  Name: `php_open_tags_review`

   ```php
   <?
     echo 1;
     # error lines: 1         
   ```


## Configuration
You can configure type of php tags that you want to use.
There are 2 types of tags:
    - long `<?php`
    - short `<?`

```php
<?php
    require __DIR__.'/vendor/autoload.php';
    
    use Funivan\Cs\Tools\Php\OpenTags;

    // Default behavior
    // Configure fixer and review to use only long php tags (<?php)
    new OpenTags\OpenTagsFixer(OpenTags\PhpOpenTagFormat::LONG);
    new OpenTags\OpenTagsReview(OpenTags\PhpOpenTagFormat::LONG);

    // Configure fixer and review to use only short php tags (<?)
    new OpenTags\OpenTagsFixer(OpenTags\PhpOpenTagFormat::SHORT);
    new OpenTags\OpenTagsReview(OpenTags\PhpOpenTagFormat::SHORT);


```

