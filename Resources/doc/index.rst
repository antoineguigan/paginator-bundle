qimnet/paginator-bundle
===================

This bundles provides :
* A paginator working over different data sources
* Templating helpers used to display the pagination

Installation
============

Add qimnet/paginator-bundle to composer.json


.. code-block:: javascript

    "require": {

        "qimnet/paginator-bundle": "~1.0@dev",
    }


Add QimnetPaginatorBundle to your application kernel

.. code-block:: php

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Qimnet\TableBundle\QimnetPaginatorBundle(),
            // ...
        );
    }


Usage
=====


Use the ``qimnet.paginator.factory`` service to create a paginator in your controller

.. code-block:: php

    <?php
    namespace ACME\WebsiteBundle\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class PaginatorController extends Controller {
        public function indexAction($page) {
            $query = $this->getDoctrine()->getRepository('AcmeWebsiteBundle:MyEntity')
                ->createQueryBuilder()
                ->getQuery();

            $pagination = $this->container->get('qimnet.paginator.factory')
                ->create('doctrine', $query, $page, array('maxPerPage'=>10));

            return $this->render(
                'ACMEWebsiteBundle:Table:pagination.html.twig',
                array(
                    'pagination'=>$pagination->createView()
                )
            );
        }
    }

The data can then be rendered in the template:

.. code-block:: twig

    {# ACMEWebsiteBundle:Pagination:index.html.twig #}
    {# ... #}
    {% for row in pagination %}
        <section>{{ row.content }}</section>
    {% endfor %}
    {{ sliding_pagination(pagination, "acme_website_pagination_index") }}

