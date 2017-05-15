<?php

namespace LinkORB\ConfigLoader\Service;

use RuntimeException;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ConfigurationLoaderYaml
{
    public function load($configPath)
    {
        if (!is_readable($configPath) || !is_file($configPath)) {
            throw new RuntimeException(
                "Unable to load configuration from \"{$configPath}\"."
            );
        }

        $input = file_get_contents($configPath);

        if ($input === false) {
            throw new RuntimeException(
                "Unable to load configuration from \"{$configPath}\"."
            );
        }

        $config = null;

        try {
            $config = Yaml::parse($input);
        } catch (ParseException $e) {
            throw new RuntimeException(
                "Unable to parse configuration at \"{$configPath}\".",
                null,
                $e
            );
        }

        return $config;
    }
}
