# Php Redundant Null Property Value

## Fixer
  Remove NULL from the properties values 
  
  Name: `redundant_null_property_value_fixer`

  *Before*:
  ```php
  <?php
      class A {
        private $userName = null;
      }
  ```

  *After*:
  ```php
  <?php
      class A {
        private $userName;
      }
  ```


## Review
  Check code for unnecessary NULL property values 

  Name: `redundant_null_property_value_review`
  ```php
  <?php
      class A {
        private $userName = null;
        private $userAge = null;
      }
      # error lines : 3, 4
  ```