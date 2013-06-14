<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Adapter\Doctrine;

use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterFactoryInterface;

class PaginatorAdapterFactory implements PaginatorAdapterFactoryInterface
{
    public function create($data, $page, $maxPerPage)
    {
        $paginator = new PaginatorAdapter();
        $paginator->initialize($data, $page, $maxPerPage);

        return $paginator;
    }
}
