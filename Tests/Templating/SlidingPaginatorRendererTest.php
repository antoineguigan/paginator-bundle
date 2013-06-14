<?php
/*
 * This file is part of the Qimnet CRUD Bundle.
 *
 * (c) Antoine Guigan <aguigan@qimnet.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Qimnet\PaginatorBundle\Tests\Templating;

use Qimnet\PaginatorBundle\Templating\SlidingPaginatorRenderer;

class SlidingPaginatorRendererTest extends \PHPUnit_Framework_TestCase
{
    public function getPagesActionData()
    {
        return array(
            array(1, 20, 10, false, false),
            array(1, 12, 2, 21, false),
            array(7, 12, 11, false,false),
            array(2, 7, 10, false, 'template'),
            array(3,9,11,false,false),
            array(6,12,11,false,false)
        );
    }
    /**
     * @dataProvider getPagesActionData
     */
    public function testRender($page, $lastPage, $defaultMaxPageCount, $maxPageCount, $template)
    {
        $templating = $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $router = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $paginatorView = $this->getMock('Qimnet\PaginatorBundle\Paginator\PaginatorViewInterface');
        $paginatorView
                ->expects($this->any())
                ->method('getLastPage')
                ->will($this->returnValue($lastPage));
        $paginatorView
                ->expects($this->any())
                ->method('getPage')
                ->will($this->returnValue($page));
        $controller = new SlidingPaginatorRenderer($templating, $router, array(
            'template'=> 'default_template',
            'max_page_count' => $defaultMaxPageCount));
        $testCase = $this;
        $router
                ->expects($this->any())
                ->method('generate')
                ->with($this->equalTo('route'), $this->callback(function($value) use ($testCase) {
                    $testCase->assertEquals('value1',$value['param1'] );
                    $testCase->assertCount(2, $value);
                    $testCase->assertInternalType('int', $value['page']);

                    return true;
                }))
                ->will($this->returnCallback(function($route, $params){
                    return "$route?page=$params[page]";
                }));
        $templating
                ->expects($this->once())
                ->method('render')
                ->with( $this->equalTo($template ?: 'default_template'),
                        $this->callback(function($parameters) use ($testCase, $paginatorView, $page, $lastPage, $defaultMaxPageCount, $maxPageCount) {
                            $testCase->assertSame($paginatorView, $parameters['pagination']);
                            $testCase->assertEquals('route?page=1', $parameters['firstPageUrl']);
                            $testCase->assertEquals("route?page=$lastPage", $parameters['lastPageUrl']);
                            $testCase->assertLessThanOrEqual($maxPageCount?:$defaultMaxPageCount, count($parameters['pages']));
                            $testCase->assertLessThanOrEqual($lastPage, count($parameters['pages']));
                            $keys = array_keys($parameters['pages']);
                            $testCase->assertArrayHasKey($page, $parameters['pages']);

                            $testCase->assertGreaterThanOrEqual(1, $keys[0]);
                            $testCase->assertLessThanOrEqual($lastPage, array_pop($keys));
                            foreach ($parameters['pages'] as $page=>$url) {
                                $testCase->assertEquals($url, "route?page=$page");
                            }

                            return true;
                        }))
                        ->will($this->returnValue('success'));
        $options = array();
        if ($template) {
            $options['template'] = $template;
        }
        if ($maxPageCount) {
            $options['max_page_count'] = $maxPageCount;
        }
        $result = $controller->render($paginatorView, 'route', array('param1'=>'value1'), $options);
        $this->assertEquals('success', $result);
    }

}
