<?php

namespace Planet\PlanetBundle\Tests\Controller;

use Planet\PlanetBundle\Tests\WebTestCase,
    Planet\PlanetBundle\Controller\PlanetController,
    DomDocument;

class PlanetControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient(
            array(),
            array(
                'SERVER_NAME' => 'planet.loc',
                'SCRIPT_FILENAME' => 'index.php'
            )
        );
    }

    public function testFeed()
    {
        $crawler = $this->client->request( 'GET', "/feed/planet" );
        $response = $this->client->getResponse();
        $container = $this->client->getContainer();

        self::assertEquals( 200, $response->getStatusCode() );
        self::assertEquals(
            $container->getParameter( 'planet.tree.blogs' ),
            $response->headers->get( 'X-Location-Id' )
        );
        self::assertEquals(
            'application/rss+xml',
            $response->headers->get( 'Content-Type' )
        );
        $dom = new DomDocument();
        self::assertTrue( $dom->loadXML( $response->getContent() ) );
        self::assertEquals(
            $container->getParameter( 'planet.feed.posts' ),
            $crawler->filter( 'item' )->count()
        );
        self::assertEquals(
            $container->getParameter( 'planet.feed.title' ),
            $crawler->filter( 'channel > title' )->text()
        );
        self::assertEquals(
            $container->getParameter( 'planet.feed.url_base' ),
            $crawler->filter( 'channel > link' )->text()
        );

        $that = $this;
        $crawler->filter( 'item' )->each(
            function ( $node ) use ( $that )
            {
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'title' ) ) );
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'link' ) ) );
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'description' ) ) );
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'guid' ) ) );
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'pubDate' ) ) );
                $that->assertEquals( 1, count( $node->getElementsByTagName( 'creator' ) ) );
                $that->assertTrue( $node->getElementsByTagName( 'title' )->item( 0 )->nodeValue != '' );
                $that->assertTrue( $node->getElementsByTagName( 'link' )->item( 0 )->nodeValue != '' );
                $that->assertTrue( $node->getElementsByTagName( 'description' )->item( 0 )->nodeValue != '' );
                $that->assertTrue( $node->getElementsByTagName( 'guid' )->item( 0 )->nodeValue != '' );
                $that->assertTrue( $node->getElementsByTagName( 'pubDate' )->item( 0 )->nodeValue != '' );
                $that->assertTrue( $node->getElementsByTagName( 'creator' )->item( 0 )->nodeValue != '' );
            }
        );

    }

    public function testPoweredBy()
    {
        $this->client->request( 'GET', "/_internal/planet:poweredBy/powered.htm" );
        $response = $this->client->getResponse();

        self::assertEquals( 200, $response->getStatusCode() );
        self::assertTrue(
            strpos(
                $response->getContent(),
                \eZPublishSDK::version( true, false, false )
            ) !== false
        );
    }

    /**
     * @dataProvider providerTopMenu
     */
    public function testTopMenu( $selectedId, $selectedCount, $selectedText )
    {
        $crawler = $this->client->request( 'GET', "/_internal/planet:topMenu/selected=$selectedId.htm" );
        $response = $this->client->getResponse();

        self::assertEquals( 200, $response->getStatusCode() );
        self::assertEquals( 2, $response->headers->get( 'X-Location-Id' ) );

        $selected = $crawler->filter( '.selected' );
        self::assertEquals(
            $selectedCount,
            $selected->count()
        );

        if ( $selectedText !== null )
        {
            self::assertEquals( $selected->text(), $selectedText );
        }

        $form = $crawler->filter( 'form' );
        self::assertEquals( 1, $form->count() );
        self::assertEquals( '/planet/search', $form->attr( 'action' ) );
        self::assertEquals(
            1, $form->filter( 'input[name=SearchText]' )->count()
        );
    }

    public function providerTopMenu()
    {
        return array(
            array( null, 0, null ),
            array( 2, 1, 'Accueil' ),
            array( 140, 1, 'Planétarium' ),
            array( 'no_selected', 0, null ),
        );
    }

}
