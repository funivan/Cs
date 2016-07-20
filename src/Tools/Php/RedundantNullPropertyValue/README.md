# Php Redundant Null Property Value

## Fixer
  Remove NULL from the properties values 
  
  Name: `redundant_null_property_value_fixer`

  *Before*:
  ```<?php
      class A {
        private $userName = null;
      }
  ```

  *After*:
  ```<?
      class A {
        private $userName;
      }
  ```


## Review
  Check code for unnecessary NULL property values 

  Name: `redundant_null_property_value_review`
