<?php

// replace with file to your own project bootstrap
$container = require_once 'index.php';

return $container->get('doctrine.orm.helperset');
