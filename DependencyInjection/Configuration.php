<?php

namespace Veridis\ColorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('veridis_color');

        $rootNode
            ->children()
                ->enumNode('default_color_mode')
                    ->values(array('hex', 'rgb', 'hsl'))
                    ->defaultValue('hex')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
