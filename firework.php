<?php

require_once 'firework/Installer.php';
require_once 'firework/Run.php';

$method = match ($argv[1]) {
    'run' => new Run(),
    'install' => new Installer(),
    default => fwrite(STDOUT, "Unknown method")
};