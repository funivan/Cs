# Php return type format

## Fixer
  Format you return type declaration.
  You can specify `before` and `after` symbols. See configuration
  By default return type should contain one space before and after.

  *Before*:
   ```php
   <?php
    function findUser():\stdClass{}
   ```

   *After*:
   ```php
   <?php
    function findUser() : \stdClass{}
   ```

  Name: `php_return_type_format_fixer`

# Configuration
  You can specify any symbols that will be places
  before and after return type declaration.

   ```php
   <?php
   require_once  __DIR__.'/vendor/autoload.php';
   
   $fixer = new \Funivan\Cs\Tools\Php\ReturnTypeFormat\ReturnTypeFormatFixer();
   $fixer->setBefore(' ');
   $fixer->setAfter(' ');

   ```


  If you want to remove any spaces just specify empty string.
   ```<?php

      $fixer = new ReturnTypeFormatFixer();
      $fixer->setBefore('');
      $fixer->setAfter('');

   // convert this
   // function findUser() : \UserModel {}
   // to this
   // function findUser():\UserModel {}
   ```



