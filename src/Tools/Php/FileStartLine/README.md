# Php file start line

## Review
  Check if php file begins with tags `<?` or `<?php` or `#!/usr/bin/env php`

  Name: `php_file_start_line_review`

  ```php
  #!/bin/php
  <?php
    echo 1;
    # error lines : 1
  ```
