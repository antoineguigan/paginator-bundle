<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Paginator;
use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterFactoryInterface;

class PaginatorFactory implements PaginatorFactoryInterface
{
    protected $adapterFactories=array();
    protected $maxPerPage;
    public function __construct($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;
    }
    public function addAdapter($alias, PaginatorAdapterFactoryInterface $paginatorAdapterFactory)
    {
        $this->adapterFactories[$alias] = $paginatorAdapterFactory;
    }
    public function create($type, $data, $page=1, array $options=array())
    {
        if (!isset($this->adapterFactories[$type])) {
            throw new \Exception("Type $type does'nt exist");
        }
        if (isset($options['maxPerPage'])) {
            $maxPerPage = $options['maxPerPage'];
            unset($options['maxPerPage']);
        } else {
            $maxPerPage = $this->maxPerPage;
        }

        return new Paginator(
                $this->adapterFactories[$type]->create($data, $page, $maxPerPage, $options),
                $page, $maxPerPage);
    }
}
