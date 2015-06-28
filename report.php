<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__.'/vendor/autoload.php';

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$loader->load('services.yml');

$application = new Application();
$application->add($container->get('kpi_report.command.list'));
$application->add($container->get('kpi_report.command.send'));
$application->run();
