<?php

namespace Planet\PlanetBundle\Tests\Parser;


use PHPUnit_Framework_TestCase,
    Planet\PlanetBundle\Import\Parser\Feed,
    DateTime;


class FeedTest extends PHPUnit_Framework_TestCase
{

    protected function getFixtureFile( $file )
    {
        return __DIR__ . '/_fixtures/' . $file;
    }

    /**
     * @expectedException Planet\PlanetBundle\Import\Parser\Exception\NotFound
     */
    public function testNotFound()
    {
        $feed = new Feed( 'doesnotexist' );
        $feed->parse();
    }

    /**
     * @expectedException Planet\PlanetBundle\Import\Parser\Exception\Invalid
     */
    public function testInvalid()
    {
        $feed = new Feed( __FILE__ );
        $feed->parse();
    }

    /**
     * @dataProvider providerValidFile
     */
    public function testValidFile( $id, $file, $count, array $posts )
    {
        $feed = new Feed( $this->getFixtureFile( $file ) );
        $result = $feed->parse();

        self::assertTrue( is_array( $result ) );
        self::assertCount( $count, $result );
        foreach ( $result as $k => $element )
        {
            self::assertInstanceOf( 'Planet\\PlanetBundle\\Import\\Post', $element );
            $expected = $posts[$k];
            foreach ( $expected as $property => $value )
            {
                self::assertEquals( $value, $element->{$property} );
            }
        }

    }

    public function providerValidFile()
    {
        return array(
            array(
                'id' => 'RSS2, empty',
                'file' => 'rss2_empty.xml',
                'count' => 0,
                'posts' => array(),
            ),
            array(
                'id' => 'RSS2, 4 posts',
                'file' => 'rss2.xml',
                'count' => 4,
                'posts' => array(
                    array(
                        'id' => 'aec379c141ec0cd59b4766ed9888c86f',
                        'title' => 'Peinture fraîche sur le Planet eZ Publish.fr',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://pwet.fr/blog/peinture_fraiche_sur_le_planet_ez_publish_fr',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::RSS, 'Wed, 20 Jun 2012 20:58:58 +0000'
                        )
                    ),
                    array(
                        'id' => 'aec379c141ec0cd59b4766ed9888c86f',
                        'title' => 'Content encoded',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://pwet.fr/blog/peinture_fraiche_sur_le_planet_ez_publish_fr',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::RSS, 'Wed, 20 Jun 2012 20:58:58 +0000'
                        )
                    ),
                    array(
                        'id' => 'http://pwet.fr/blog/peinture_fraiche_sur_le_planet_ez_publish_fr',
                        'title' => 'Peinture fraîche sur le Planet eZ Publish.fr',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://pwet.fr/blog/peinture_fraiche_sur_le_planet_ez_publish_fr',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::RSS, 'Wed, 20 Jun 2012 20:58:58 +0000'
                        )
                    ),
                    array(
                        'id' => 'idwithspacesaround',
                        'title' => 'Peinture fraîche sur le Planet eZ Publish.fr',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://pwet.fr/blog/peinture_fraiche_sur_le_planet_ez_publish_fr',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::RSS, 'Wed, 20 Jun 2012 20:58:58 +0000'
                        )
                    ),
                )
            ),
            array(
                'id' => 'Atom 1.0, 4 posts',
                'file' => 'atom10.xml',
                'count' => 3,
                'posts' => array(
                    array(
                        'id' => 'aec379c141ec0cd59b4766ed9888c86f',
                        'title' => 'Simple entry with id',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://www.planet-ezpublish.fr/simple-entry',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::ATOM, '2012-11-12T15:54:38+00:00'
                        )
                    ),
                    array(
                        'id' => 'http://www.planet-ezpublish.fr/simple-entry-id',
                        'title' => 'Simple entry with url as id',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://www.planet-ezpublish.fr/simple-entry-id',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::ATOM, '2012-11-12T17:54:38+00:00'
                        )
                    ),
                    array(
                        'id' => 'idspacesaround',
                        'title' => 'Entry with spaces everywhere',
                        'text' => '<p>Hello!</p>',
                        'url' => 'http://www.planet-ezpublish.fr/spaces',
                        'publishedDate' => DateTime::createFromFormat(
                            DateTime::ATOM, '2012-11-12T17:54:38+00:00'
                        )
                    ),
                ),
            ),
            array(
                'id' => 'Atom 1.0, empty',
                'file' => 'atom10_empty.xml',
                'count' => 0,
                'posts' => array()
            ),
        );

    }



}

