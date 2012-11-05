<?php

namespace Planet\PlanetBundle\Twig;

use eZ\Publish\Core\Repository\Values\Content\Location;

class PlanetExtension extends \Twig_Extension
{
    protected $container;

    public function __construct( $container )
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'Planet';
    }

    public function getFunctions()
    {
        return array(
            'parent_location' => new \Twig_Function_Method(
                $this,
                'parentLocation'
            ),
            'location_content' => new \Twig_Function_Method(
                $this,
                'getContent'
            )
        );
    }

    public function getFilters()
    {
        return array(
            'clean_rewrite_xhtml' => new \Twig_Filter_Method(
                $this,
                'cleanRewriteXHTML'
            )
        );
    }

    public function getGlobals()
    {
        $global = array(
            'planet' => array(
                'tree' => array(
                    'root' => $this->container->getParameter( 'planet.tree.root' ),
                    'blogs' => $this->container->getParameter( 'planet.tree.blogs' ),
                    'planetarium' => $this->container->getParameter( 'planet.tree.planetarium' ),
                ),
                'page' => array(
                    'posts' => $this->container->getParameter( 'planet.page.posts' ),
                    'title' => $this->container->getParameter( 'planet.page.title' ),
                )
            )
        );
        return $global;
    }

    public function parentLocation( Location $location )
    {
        $repository = $this->container->get( 'ezpublish.api.repository' );
        return $repository->getLocationService()->loadLocation( $location->parentLocationId );
    }

    public function getContent( Location $location )
    {
        $repository = $this->container->get( 'ezpublish.api.repository' );
        return $repository->getContentService()->loadContent( $location->contentInfo->id );
    }

    public function cleanRewriteXHTML( $html, $baseUri )
    {
        return \eZPlaneteUtils::cleanRewriteXHTML( $html, $baseUri );
    }

}

