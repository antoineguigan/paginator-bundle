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

use Qimnet\PaginatorBundle\Adapter\PaginatorAdapterFactoryInterface;

class PaginatorAdapterFactory implements PaginatorAdapterFactoryInterface
{
    protected $solr;
    public function __construct(\SolrClient $solr)
    {
        $this->solr = $solr;
    }
    public function create($data, $page, $maxPerPage)
    {
        $paginator = new PaginatorAdapter($this->solr);
        $paginator->initialize($data,$page,$maxPerPage);

        return $paginator;
    }
}
