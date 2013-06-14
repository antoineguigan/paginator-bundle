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
use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterInterface;

class Paginator implements PaginatorInterface
{
    protected $adapter;
    protected $maxPerPage;
    protected $page;

    public function __construct(PaginatorAdapterInterface $adapter, $page, $maxPerPage)
    {
        $this->adapter = $adapter;
        $this->maxPerPage = $maxPerPage;
        $this->page = $page;
    }
    public function getAdapter()
    {
        return $this->adapter;
    }

    public function createView()
    {
        return new PaginatorView($this->adapter, $this->page, $this->maxPerPage);
    }
}
