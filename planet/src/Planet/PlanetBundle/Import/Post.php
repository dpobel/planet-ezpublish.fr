<?php

namespace Planet\PlanetBundle\Import;


/**
 * A dumb Post struct.
 */
class Post
{
    /**
     * Id of the post
     *
     * @var string
     */
    public $id;

    /**
     * Title of the post
     *
     * @var string
     */
    public $title;

    /**
     * text of the post, might be in HTML
     *
     * @var string
     */
    public $text;

    /**
     * URL of the post
     *
     * @var string
     */
    public $url;

    /**
     * Published date of the post
     *
     * @var DateTime
     */
    public $publishedDate;
}

