#!/usr/bin/env php
<?php

  use Funivan\Cs\Console\Application;

  $projectDirectory = __DIR__ . '/../../../..';

  if (!file_exists($projectDirectory . '/vendor/autoload.php')) {
    $projectDirectory = __DIR__ . '/..';
  }


  require_once $projectDirectory . '/vendor/autoload.php';

  $application = new Application($projectDirectory);
  $application->run();