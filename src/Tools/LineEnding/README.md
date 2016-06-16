# Line ending

## Fixer
  Invalid line endings `CRLF` (`\r\n`) and `CR` (`\r`) will be replaced with `LF` (`\n`)

  Name: `line_ending_fixer`

  *Before*:
  ```
...echo 1;\r\n
...\r\n
...echo 2;\r\n
  ```
  *After*:
  ```
...echo 1;\n
...\n
...echo 2;\n
  ```

## Review
  Find `CRLF` and `CR` line endings

  Name: `line_ending_review`