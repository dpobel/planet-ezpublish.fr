<?php

namespace Planet\PlanetBundle\Tests\Twig;


use PHPUnit_Framework_TestCase,
    Planet\PlanetBundle\Twig\PlanetExtension;


class PlanetExtensionTest extends PHPUnit_Framework_TestCase
{
    protected function getContainerMock()
    {
        return $this->getMock(
            'Symfony\\Component\\DependencyInjection\\Container'
        );
    }


    /**
     * @dataProvider providerShorten
     */
    public function testShorten( $string, $max, $suffix, $expected )
    {
        $extension = new PlanetExtension( $this->getContainerMock() );
        self::assertEquals(
            $expected,
            $extension->shorten( $string, $max, $suffix )
        );
    }

    public function providerShorten()
    {
        $utf8Dots = '…';
        $dots = '...';
        $data = array(
            array( 
                '0123456789',
                10,
                $dots,
                '0123456789'
            ),
            array( 
                '0123456789',
                15,
                $dots,
                '0123456789'
            ),
            array( 
                '0123456789',
                5,
                $dots,
                '0123456' . $dots
            ),
            array( 
                '0é234éèçùà',
                10,
                $dots,
                '0é234éèçùà'
            ),
            array( 
                '0é234éèçùà',
                15,
                $dots,
                '0é234éèçùà'
            ),
            array( 
                '0é234éèçùà',
                5,
                $dots,
                '0é234éè' . $dots
            ),
            array( 
                '0123456789',
                10,
                $utf8Dots,
                '0123456789'
            ),
            array( 
                '0123456789',
                15,
                $utf8Dots,
                '0123456789'
            ),
            array( 
                '0123456789',
                5,
                $utf8Dots,
                '012345678' . $utf8Dots
            ),
            array( 
                '0é234éèçùà',
                10,
                $utf8Dots,
                '0é234éèçùà'
            ),
            array( 
                '0é234éèçùà',
                15,
                $utf8Dots,
                '0é234éèçùà'
            ),
            array( 
                '0é234éèçùà',
                5,
                $utf8Dots,
                '0é234éèçù' . $utf8Dots
            ),

        );
        return $data;
    }



}

