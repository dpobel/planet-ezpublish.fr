<?php

namespace Planet\PlanetBundle\Import;


/**
 * Parser interface. The parse method is supposed to return an array of Post.
 */
interface Parser
{

    /**
     * Returns an array of posts
     *
     * @return Planet\PlanetBundle\Import\Post[]
     */
    public function parse();

}
