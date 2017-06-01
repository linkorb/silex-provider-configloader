# linkorb/silex-provider-configloader

Services providing loading of configuration files.

Two services are provided and registered with a Pimple container:-

- `config.loader.ini`: loads ini files
- `config.loader.yaml`: loads Yaml files

A third, optional service `comfig.loader.env` is registered if the
[Symfony Dotenv][] component is installed.


## Install

Install using composer:-

    $ composer require linkorb/silex-provider-configloader

and optionally require symfony/dotenv during development:-

    $ composer require --dev symfony/dotenv

Then register the provider:-

    // app/app.php
    use LinkORB\ConfigLoader\Provider\ConfigurationLoaderProvider;
    ...
    $app->register(new ConfigurationLoaderProvider);


## Usage

    $config = $app['config.loader.ini']->load('path/to/config.ini');

[Symfony Dotenv]: <https://symfony.com/doc/master/components/dotenv.html>
  "The Dotenv Component (The Symfony Components)"
