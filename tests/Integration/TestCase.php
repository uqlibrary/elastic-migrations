<?php declare(strict_types=1);

namespace Elastic\Migrations\Tests\Integration;

use Elastic\Client\ServiceProvider as ClientServiceProvider;
use OpenSearch\Client;
use OpenSearch\ClientBuilder;
use Elastic\Migrations\ServiceProvider as MigrationsServiceProvider;
use Illuminate\Config\Repository;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected Repository $config;

    protected function getPackageProviders($app): array
    {
        return [
            MigrationsServiceProvider::class,
            ClientServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $this->config = $app['config'];
        $this->config->set('elastic.migrations.database.table', 'test_elastic_migrations');
        $this->config->set('elastic.migrations.storage.default_path', realpath(__DIR__ . '/../migrations'));

        $app->singleton(Client::class, function () {
            return ClientBuilder::create()
                ->build();
        });
    }
}
