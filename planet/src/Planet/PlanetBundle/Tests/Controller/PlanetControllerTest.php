<?php

namespace Planet\PlanetBundle\Tests\Controller;

use PHPUnit_Framework_TestCase,
    Planet\PlanetBundle\Controller\PlanetController;

class PlanetControllerTest extends PHPUnit_Framework_TestCase
{

    protected function getViewManagerMock()
    {
        return $this
            ->getMockBuilder(
                'eZ\\Publish\\Core\\MVC\\Symfony\\View\\Manager'
            )
            ->disableOriginalConstructor()
            ->getMock();
    }


    public function testPoweredBy()
    {
        $controller = new PlanetController(
            $this->getViewManagerMock()
        );
        $response = $controller->poweredBy();

        self::assertInstanceOf(
            'Symfony\\Component\\HttpFoundation\\Response',
            $response
        );
        self::assertTrue(
            strpos(
                $response->getContent(),
                \eZPublishSDK::version( true, false, false )
            ) !== false
        );
    }

}
