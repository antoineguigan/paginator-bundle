<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Adapter\Solr;

use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterInterface;

class PaginatorAdapter implements PaginatorAdapterInterface
{
    protected $results=array();
    protected $response;
    protected $count=0;
    protected $solr;

    public function __construct(\SolrClient $solr)
    {
        $this->solr = $solr;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }

    public function getResultCount()
    {
        return $this->count;
    }
    public function getResponse()
    {
        return $this->response;
    }

    public function initialize($data, $page, $maxPerPage, array $options = array())
    {
        $data->setStart(($page-1)*$maxPerPage);
        $data->setRows($maxPerPage);
        $queryResponse = $this->solr->query($data);
        $this->response = $queryResponse->getResponse();
        if ($this->response->response['docs']) $this->results = $this->response->response['docs'];
        $this->count = $this->response->response->numFound;
    }

    public function count()
    {
        return count($this->results);
    }

    public function offsetExists($offset)
    {
        return $offset < $this->count();
    }

    public function offsetGet($offset)
    {
        return $this->results[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->results[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->results[$offset]);
    }
}
