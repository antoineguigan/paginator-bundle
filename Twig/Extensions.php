<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Qimnet\PaginatorBundle\Paginator\PaginatorViewInterface;

class Extensions extends \Twig_Extension
{
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function getName()
    {
        return 'qimnet_paginator_extension';
    }
    public function getFunctions()
    {
        return array(
            'sliding_pagination'=>new \Twig_Function_Method($this, 'slidingPaginationFunction', array('is_safe'=>array('html'))),
        );
    }
    public function slidingPaginationFunction(PaginatorViewInterface $pagination, $route, array $routeParameters=array(), array $options=array())
    {
        return $this->container->get('qimnet.crud.templating.sliding_paginator')
                ->render($pagination, $route, $routeParameters, $options);
    }
}
