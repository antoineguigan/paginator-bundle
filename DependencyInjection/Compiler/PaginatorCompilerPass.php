<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PaginatorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('qimnet.paginator.factory')) {
            return;
        }
        $definition = $container->getDefinition('qimnet.paginator.factory');
        $taggedServices = $container->findTaggedServiceIds('qimnet.paginator.adapter.factory');
        foreach ($taggedServices as $id=>$attributes) {
            $definition->addMethodCall('addAdapter', array($attributes[0]['alias'], new Reference($id)));
        }
    }
}
