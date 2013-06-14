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

use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorAdapter implements PaginatorAdapterInterface
{
    protected $values=array();
    protected $count;

    public function getResultCount()
    {
        return $this->count;
    }

    public function initialize($data, $page, $maxPerPage, array $options=array())
    {
        $data
            ->setFirstResult(($page-1)*$maxPerPage)
            ->setMaxResults($maxPerPage);
        $paginator = new Paginator($data, isset($options["fetchJoinCollection"]) ? $options["fetchJoinCollection"] : false);
        foreach ($paginator as $row) {
            $this->values[] = $row;
        }
        $this->count = count($paginator);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function count()
    {
        return count($this->values);
    }

    public function offsetExists($offset)
    {
        return $offset < $this->count();
    }

    public function offsetGet($offset)
    {
        throw new \RuntimeException('UNIMPLEMENTED');
    }

    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('UNIMPLEMENTED');
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException('UNIMPLEMENTED');
    }
}
