<?php

namespace Evrinoma\EximBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Evrinoma\EximBundle\DependencyInjection\EvrinomaEximBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EvrinomaEximBundle
 *
 * @package Evrinoma\EximBundle
 */
class EvrinomaEximBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                    ['Evrinoma\EximBundle\Entity'],
                    [sprintf('%s/Entity', $this->getPath())]
                )
            );
        }
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaEximBundleExtension();
        }

        return $this->extension;
    }
}