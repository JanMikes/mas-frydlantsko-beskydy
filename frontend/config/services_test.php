<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $configurator): void
{
    $services = $configurator->services();

    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    // Data fixtures
    $services->load('MASFB\\Web\\Tests\\DataFixtures\\', __DIR__ . '/../tests/DataFixtures/{*.php}');
};
