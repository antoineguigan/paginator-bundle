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

interface PaginatorFactoryInterface
{
    public function addAdapter($alias, PaginatorAdapterFactoryInterface $paginatorAdapterFactory);
    public function create($type, $data, $page=1, array $options=array());
}
