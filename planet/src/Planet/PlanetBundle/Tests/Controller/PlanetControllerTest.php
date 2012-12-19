<?php

namespace Planet\PlanetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Planet\PlanetBundle\Controller\PlanetController;

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
