<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Adapter\Collection;

use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterInterface;

class PaginatorAdapter implements PaginatorAdapterInterface
{
    protected $data;
    protected $maxPerPage;
    protected $page;

    public function getResultCount()
    {
        return count($this->data);
    }

    public function initialize($data, $page, $maxPerPage, array $options=array())
    {
        $this->data = $data;
        $this->maxPerPage = $maxPerPage;
        $this->page = $page;
    }

    protected function getFirstOffset()
    {
        return ($this->page-1)*$this->maxPerPage;
    }

    public function getIterator()
    {
        if ($this->data instanceof \Iterator) {
            $iterator = $this->data;
        } elseif ($this->data instanceof \IteratorAggregate) {
            $iterator = $this->data->getIterator();
        } elseif (is_array($this->data)) {
            $iterator = new \ArrayIterator($this->data);
        }

        return new \LimitIterator($iterator, $this->getFirstOffset(), $this->maxPerPage);
    }

    public function count()
    {
        return min($this->maxPerPage, max(0,count($this->data) - $this->getFirstOffset()));
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$this->getFirstOffset() + $offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$this->getFirstOffset() + $offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$this->getFirstOffset() + $offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$this->getFirstOffset() + $offset]);
    }
}
