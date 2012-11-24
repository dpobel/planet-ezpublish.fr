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
     * @dataProvider providerCleanRewriteXHTML
     */
    public function testCleanRewriteXHTML( $html, $baseUri, $expected )
    {
        $extension = new PlanetExtension( $this->getContainerMock() );
        if ( $expected === '' )
        {
            self::assertEquals(
                $expected,
                $extension->cleanRewriteXHTML( $html, $baseUri )
            );
        }
        else
        {
            self::assertXmlStringEqualsXmlString(
                $expected,
                $extension->cleanRewriteXHTML( $html, $baseUri )
            );
        }
    }

    public function providerCleanRewriteXHTML()
    {
        return array(
            array(
                '',
                '',
                ''
            ),
            array(
                '   ',
                '',
                ''
            ),
            array(
                '<p>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p>test',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<P>test</P>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p><script>alert("toto");</script>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p onclick=\'alert("toto");\'>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<br><br><br><p>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<br /><br /><br /><p>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p><a name="anchor"></a>test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p><a href="http://test" target="_blank">test</a></p>',
                '',
                '<div><p><a href="http://test">test</a></p></div>'
            ),
            array(
                '<p align="center">test</p>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<img src="http://test/img.png" valign="middle" alt="" />',
                '',
                '<div><img src="http://test/img.png" alt=""/></div>'
            ),
            array(
                '<table summary="" border="0" cellspacing="2" cellpadding="3" width="200"><tr><td>table</td></tr></table>',
                '',
                '<div><table><tr><td>table</td></tr></table></div>',
            ),
            array(
                '<p>test</p><div style="font-size:2em;"><a href="http://blog.developpez.com/">test</a></div>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p>test</p><div class="tweetmeme_button">test</div>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p>test</p><pre></pre>',
                '',
                '<div><p>test</p></div>'
            ),
            array(
                '<p>test</p><pre> code    </pre>',
                '',
                '<div><p>test</p><pre>code</pre></div>'
            ),
            array(
                '<p><a href="/test">test</a></p>',
                'http://example.com',
                '<div><p><a href="http://example.com/test">test</a></p></div>'
            ),
            array(
                '<p><img src="/test" alt="" /></p>',
                'http://example.com',
                '<div><p><img src="http://example.com/test" alt="" /></p></div>'
            ),
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

