<?php

namespace LinkORB\ConfigLoader\Service;

use RuntimeException;

class ConfigurationLoaderIni
{
    public function load($configPath)
    {
        if (!is_readable($configPath) || !is_file($configPath)) {
            throw new RuntimeException(
                "Unable to load configuration from \"{$configPath}\"."
            );
        }

        $config = parse_ini_file($configPath, true);

        if ($config === false) {
            throw new RuntimeException(
                "Unable to parse configuration at \"{$configPath}\"."
            );
        }

        return $config;
    }
}
