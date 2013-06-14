<?php

namespace Qimnet\PaginatorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class QimnetPaginatorBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependencyInjection\Compiler\SolrCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\PaginatorCompilerPass);
    }
}
