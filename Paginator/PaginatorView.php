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

class PaginatorView implements \IteratorAggregate, \Countable, \ArrayAccess, PaginatorViewInterface
{
    protected $adapter;
    protected $maxPerPage;
    protected $maxPages=10;

    public function __construct(PaginatorAdapterInterface $adapter, $page,  $maxPerPage)
    {
        $this->page = $page;
        $this->maxPerPage = $maxPerPage;
        $this->adapter = $adapter;
    }

    public function getIterator()
    {
        return $this->adapter->getIterator();
    }
    public function getPage()
    {
        return $this->page;
    }
    public function getLastPage()
    {
        return ceil($this->adapter->getResultCount()/$this->maxPerPage);
    }
    public function getResultCount()
    {
        return $this->adapter->getResultCount();
    }
    public function getMaxPerPage()
    {
        return $this->maxPerPage;
    }

    public function count()
    {
        return $this->adapter->count();
    }

    public function offsetExists($offset)
    {
        return $this->adapter->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->adapter->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->adapter->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->adapter->offsetUnset($offset);
    }
}
