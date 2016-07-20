# Line After Open Tag

## Fixer
  Set 1 empty line after php open tag inside php files

  Name: `php_line_after_open_tag_fixer`

  *Before*:
  ```php
  <?php
    echo 1;
  ```

  *After*:
  ```php
  <?php

    echo 1;
  ```


## Review
  Check for 1 empty line after php open tag

  Name: `php_line_after_open_tag_review`

  ```php
     <?php
           echo 1;
     # error lines : 1
  ```



## Todo
 [ ] create configuration. User can specify number of lines