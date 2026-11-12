<?php

namespace LinkORB\Test\ConfigLoader\Service;

use PHPUnit_Framework_TestCase;
use RuntimeException;
use Symfony\Component\Yaml\Exception\ParseException;

use LinkORB\ConfigLoader\Service\ConfigurationLoaderYaml;

class ConfigurationLoaderYamlTest extends PHPUnit_Framework_TestCase
{
    private $loader;
    private $files = array();

    protected function setUp()
    {
        $this->loader = new ConfigurationLoaderYaml();
    }

    protected function tearDown()
    {
        foreach ($this->files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        if (in_array('cfgfalse', stream_get_wrappers(), true)) {
            stream_wrapper_unregister('cfgfalse');
        }
    }

    public function testLoadReturnsParsedMapping()
    {
        $path = $this->temporaryFile("name: onatal\ncount: 2\n");

        $this->assertSame(
            array(
                'name' => 'onatal',
                'count' => 2,
            ),
            $this->loader->load($path)
        );
    }

    public function testLoadThrowsWhenPathIsNotReadable()
    {
        $path = sys_get_temp_dir() . '/configuration-loader-yaml-missing-' . uniqid('', true) . '.yml';

        $this->assertUnableToLoad($path);
    }

    public function testLoadThrowsWhenPathIsNotAFile()
    {
        $this->assertUnableToLoad(sys_get_temp_dir());
    }

    public function testLoadThrowsWhenFileContentsCannotBeRead()
    {
        stream_wrapper_register(
            'cfgfalse',
            'LinkORB\\Test\\ConfigLoader\\Service\\ConfigurationLoaderYamlFalseStream'
        );

        $path = 'cfgfalse://config.yml';
        set_error_handler(function () {
            return true;
        });

        try {
            $this->assertUnableToLoad($path);
        } finally {
            restore_error_handler();
        }
    }

    public function testLoadWrapsYamlParseException()
    {
        $path = $this->temporaryFile("\tfoo: bar\n");

        try {
            $this->loader->load($path);
            $this->fail('Expected RuntimeException.');
        } catch (RuntimeException $exception) {
            $this->assertSame(
                'Unable to parse configuration at "' . $path . '".',
                $exception->getMessage()
            );
            $this->assertSame(0, $exception->getCode());
            $this->assertInstanceOf(ParseException::class, $exception->getPrevious());
            $this->assertSame(
                'A YAML file cannot contain tabs as indentation at line 1 (near "' . "\tfoo: bar" . '").',
                $exception->getPrevious()->getMessage()
            );
        }
    }

    private function assertUnableToLoad($path)
    {
        try {
            $this->loader->load($path);
            $this->fail('Expected RuntimeException.');
        } catch (RuntimeException $exception) {
            $this->assertSame(
                'Unable to load configuration from "' . $path . '".',
                $exception->getMessage()
            );
            $this->assertSame(0, $exception->getCode());
            $this->assertNull($exception->getPrevious());
        }
    }

    private function temporaryFile($contents)
    {
        $path = tempnam(sys_get_temp_dir(), 'yaml');
        $this->files[] = $path;
        file_put_contents($path, $contents);

        return $path;
    }
}

class ConfigurationLoaderYamlFalseStream
{
    public $context;

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return false;
    }

    public function url_stat($path, $flags)
    {
        return array(
            'dev' => 0,
            'ino' => 0,
            'mode' => 0100644,
            'nlink' => 1,
            'uid' => 0,
            'gid' => 0,
            'rdev' => 0,
            'size' => 0,
            'atime' => 0,
            'mtime' => 0,
            'ctime' => 0,
            'blksize' => 0,
            'blocks' => 0,
        );
    }
}
