<?php

namespace LinkORB\Test\ConfigLoader\Provider;

use PHPUnit_Framework_TestCase;
use Pimple\Container;

use LinkORB\ConfigLoader\Provider\ConfigurationLoaderProvider;
use LinkORB\ConfigLoader\Service\ConfigurationLoaderIni;
use LinkORB\ConfigLoader\Service\ConfigurationLoaderYaml;

class CongiurationLoaderProviderTest extends PHPUnit_Framework_TestCase
{
    private $container;
    private $provider;

    protected function setUp()
    {
        $this->container = new Container();
        $this->provider = new ConfigurationLoaderProvider;
        $this->provider->register($this->container);
    }

    public function testRegisterWillRegisterIniLoader()
    {
        $this->assertInstanceOf(
            ConfigurationLoaderIni::class,
            $this->container['config.loader.ini'],
            'The service "config.loader.ini" is an instance of ConfigurationLoaderIni.'
        );
    }

    public function testRegisterWillRegisterYamlLoader()
    {
        $this->assertInstanceOf(
            ConfigurationLoaderYaml::class,
            $this->container['config.loader.yaml'],
            'The service "config.loader.yaml" is an instance of ConfigurationLoaderYaml.'
        );
    }
}
