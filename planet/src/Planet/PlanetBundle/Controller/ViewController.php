<?php

namespace Planet\PlanetBundle\Controller;

use eZ\Publish\Core\MVC\Symfony\Controller\Content\ViewController as APIViewController,
    Symfony\Component\HttpFoundation\Response,
    DateTime;

class ViewController extends APIViewController
{

    protected function buildResponse( $etag, DateTime $lastModified )
    {
        $request = $this->getRequest();
        $response = new Response();
        if ( $this->getParameter( 'content.view_cache' ) === true )
        {
            $response->setPublic();
            $response->setEtag( $etag );

            // If-None-Match is the request counterpart of Etag response header
            // Making the response to vary against it ensures that an HTTP
            // reverse proxy caches the different possible variations of the
            // response as it can depend on user role for instance.
            if ( $request->headers->has( 'If-None-Match' )
                && $this->getParameter( 'content.ttl_cache' ) === true )
            {
                $response->setVary( 'If-None-Match' );
                $response->setSharedMaxAge(
                    $this->getParameter( 'content.default_ttl' )
                );
            }

            $response->setLastModified( $lastModified );
        }
        return $response;
    }



}

