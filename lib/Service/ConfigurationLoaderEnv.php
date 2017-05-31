<?php

namespace LinkORB\ConfigLoader\Service;

use RuntimeException;

use Symfony\Component\Dotenv\Dotenv;

class ConfigurationLoaderEnv
{
    private $loader;

    public function __construct(Dotenv $dotenv)
    {
        $this->loader = $dotenv;
    }

    public function load($configPath)
    {
        if (!is_readable($configPath) || !is_file($configPath)) {
            throw new RuntimeException(
                "Unable to load configuration from \"{$configPath}\"."
            );
        }

        $this->loader->load($configPath);
    }
}
