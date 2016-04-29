# Line ending
  `LF` - Line Feed `\n`
  `CR` - Carriage Return `\r`
  `CRLF` - `\r\n`


## Fixer
  Invalid line endings `CRLF` and `CR` will be replaced with `LF`

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
\n
...echo 2;\n
  ```

## Review
  Find `CRLF` and `CR` line ending
  Name: `line_ending_review`

## Todo
Create configuration
