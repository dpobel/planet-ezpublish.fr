<?php

namespace Planet\PlanetBundle\Import\Parser;

use Planet\PlanetBundle\Import\Parser,
    ezcFeed,
    ezcFeedParseErrorException,
    ezcBaseFileNotFoundException,
    DateTime,

    Planet\PlanetBundle\Import\Post,

    Planet\PlanetBundle\Import\Parser\Exception\Invalid,
    Planet\PlanetBundle\Import\Parser\Exception\NotFound;

/**
 * Feed parser. It is able to parse RSS or ATOM feed and find posts in it.
 */
class Feed implements Parser
{
    /**
     * Feed url
     *
     * @var string
     */
    protected $feedUrl;

    /**
     * Constructor of Parser\Feed
     *
     * @param string $feedUrl
     */
    public function __construct( $feedUrl )
    {
        $this->feedUrl = $feedUrl;
    }

    /**
     * Returns an array of posts found in the feed
     *
     * @throw Planet\PlanetBundle\Import\Parser\Exception\NotFound
     * @throw Planet\PlanetBundle\Import\Parser\Exception\Invalid
     * @return Planet\PlanetBundle\Import\Post[]
     */
    public function parse()
    {
        $feed = $this->getInternalFeedParser();
        $result = array();
        if ( !is_array( $feed->item ) || empty( $feed->item ) )
        {
            return $result;
        }

        foreach ( $feed->item as $item )
        {
            $post = new Post();
            $post->id = isset( $item->id ) ? trim( $item->id ) : trim( $item->link[0] );
            $post->title = trim( $item->title );
            $post->text = trim( $item->description );
            if ( isset( $item->Content ) && isset( $item->Content->encoded ) )
                $post->text = trim( $item->Content->encoded );
            $post->url = trim( $item->link[0] );
            if ( isset( $item->published ) )
            {
                $post->publishedDate = $item->published->date;
            }
            elseif ( isset( $item->DublinCore ) && isset( $item->DublinCore->date[0] ) )
            {
                $post->publishedDate = $item->DublinCore->date[0]->date;
            }
            else
            {
                $post->publishedDate = new DateTime();
            }
            $result[] = $post;
        }

        return $result;
    }

    /**
     * Returns the internal feed parser, ezcFeed at the moment.
     *
     * @throw Planet\PlanetBundle\Import\Parser\Exception\NotFound
     * @throw Planet\PlanetBundle\Import\Parser\Exception\Invalid
     * @return ezcFeed
     */
    protected function getInternalFeedParser()
    {
        try
        {
            return ezcFeed::parse( $this->feedUrl );
        }
        catch( ezcBaseFileNotFoundException $e )
        {
            throw new NotFound();
        }
        catch( ezcFeedParseErrorException $e )
        {
            throw new Invalid();
        }
    }

}
