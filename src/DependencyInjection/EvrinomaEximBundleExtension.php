<?php


namespace Evrinoma\EximBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EvrinomaEximBundleExtension
 *
 * @package Evrinoma\EximBundle\DependencyInjection
 */
class EvrinomaEximBundleExtension extends Extension
{
//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('fixtures.yml');        
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return 'exim';
    }
//endregion Getters/Setters
}