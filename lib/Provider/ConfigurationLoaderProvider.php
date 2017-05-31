<?php

namespace LinkORB\ConfigLoader\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use LinkORB\ConfigLoader\Service\ConfigurationLoaderEnv;
use LinkORB\ConfigLoader\Service\ConfigurationLoaderIni;
use LinkORB\ConfigLoader\Service\ConfigurationLoaderYaml;

class ConfigurationLoaderProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['config.loader.ini'] = function () {
            return new ConfigurationLoaderIni;
        };
        $app['config.loader.yaml'] = function () {
            return new ConfigurationLoaderYaml;
        };
        if (class_exists('\Symfony\Component\Dotenv\Dotenv')) {
            $app['config.loader.env'] = function () {
                return new ConfigurationLoaderEnv(
                    new \Symfony\Component\Dotenv\Dotenv
                );
            };
        }
    }
}
