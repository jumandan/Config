<?php
namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use JumandanConfig\Client;
use JumandanConfig\Exception;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testPathDoesNotExist()
    {
        $this->expectException(Exception\ConfigException::class);
        Client::reg('/');
        Client::get('non-existent-config');
    }

    public function testExistentConfig()
    {
        Client::reg(__DIR__);
        $cfg = Client::get('existent-config');
        $this->assertObjectHasAttribute('field', $cfg);
        $this->assertEquals($cfg->field, 'value');
    }
}
