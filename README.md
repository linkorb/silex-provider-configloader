# linkorb/silex-provider-configloader

Services providing loading of configuration files.

Two services are provided and registered with a Pimple container:-

- `config.loader.ini`: loads ini files
- `config.loader.yaml`: loads Yaml files


## Install

Install using composer:-

    $ composer require linkorb/silex-provider-configloader

Then register the provider:-

    // app/app.php
    use LinkORB\ConfigLoader\Provider\ConfigurationLoaderProvider;
    ...
    $app->register(new ConfigurationLoaderProvider);


## Usage

    $config = $app['config.loader.ini']->load('path/to/config.ini');
