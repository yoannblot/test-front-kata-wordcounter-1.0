<?php
declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

define('TESTS_PATH', ROOT_PATH . 'tests' . DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR);

/**
 * Autoload class from its name.
 *
 * @param string $sClassName
 *            class name.
 */
function autoloadTestClass($sClassName)
{
    $sFilePath = TESTS_PATH . $sClassName . '.php';
    $sFilePath = str_replace('\\', '/', $sFilePath);
    if (is_file($sFilePath)) {
        /** @noinspection PhpIncludeInspection */
        require_once $sFilePath;
    }
}

spl_autoload_register('autoloadTestClass');