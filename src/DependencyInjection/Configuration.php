<?php


namespace Evrinoma\EximBundle\DependencyInjection;

use Evrinoma\EximBundle\Menu\EximMenu;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\EximBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('delta8');
        $rootNode    = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('menu')->defaultValue(EximMenu::class)
                ->info('This option is used for plug menu as tag serivce')
            ->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}