<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Adapter;

interface PaginatorAdapterInterface extends \IteratorAggregate, \Countable, \ArrayAccess
{
    public function initialize($data, $page, $maxPerPage, array $options=array());
    public function getResultCount();
}
