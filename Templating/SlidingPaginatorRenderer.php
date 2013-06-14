<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Templating;
use Qimnet\PaginatorBundle\Paginator\PaginatorViewInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SlidingPaginatorRenderer implements PaginatorRendererInterface
{
    protected $templating;
    protected $router;
    protected $defaultOptions;

    public function __construct(EngineInterface $templating, RouterInterface $router, array $defaultOptions)
    {
        $this->templating = $templating;
        $this->router = $router;
        $this->defaultOptions = $defaultOptions;
    }
    protected function getUrl($route, array $parameters, $page)
    {
        $parameters['page'] =  $page;

        return $this->router->generate($route, $parameters);
    }
    protected function setDefaultOptions(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
                ->setDefaults(array(
                    'max_page_count'=>11,
                    'template'=>'QimnetPaginatorBundle:Paginator:pagination.html.twig',
                    'template_parameters'=>array()
                ));
    }
    public function render(PaginatorViewInterface $pagination, $route, array $routeParameters=array(), array $options=array())
    {
        $resolver = new OptionsResolver;
        $this->setDefaultOptions($resolver, $options);
        $options = $resolver->resolve($options + $this->defaultOptions);
        if ($pagination->getLastPage() <= $options['max_page_count']) {
            $firstPage = 1;
            $lastPage = $pagination->getLastPage();
        } else {
            $leftMaxPageCount = round($options['max_page_count']/2-1);
            $firstPage = max(1, $pagination->getPage() - $leftMaxPageCount);
            if ($firstPage==2) {
                $firstPage = 1;
            } elseif (($pagination->getPage() + $leftMaxPageCount + 1 == $pagination->getLastPage())) {
                $firstPage++;
            }
            $lastPage = min($pagination->getLastPage(), $firstPage + $options['max_page_count']-1);
        }
        $pages = array();
        for ($p=$firstPage; $p < $lastPage; $p++) {
            $pages[$p] = $this->getUrl($route, $routeParameters, $p);
        }

        return $this->templating->render($options['template'], $options['template_parameters'] + array(
            'pagination'=>$pagination,
            'previousPageUrl'=>$this->getUrl($route, $routeParameters,  $pagination->getPage()-1),
            'nextPageUrl'=>$this->getUrl($route, $routeParameters,  $pagination->getPage()+1),
            'firstPageUrl'=>  $this->getUrl($route, $routeParameters, 1),
            'lastPageUrl'=>  $this->getUrl($route, $routeParameters, $pagination->getLastPage()),
            'pages'=>$pages
        ));
    }
}
