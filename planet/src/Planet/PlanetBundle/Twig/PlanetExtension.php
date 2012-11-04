<?php

namespace Planet\PlanetBundle\Twig;

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
                )
            )
        );
        return $global;
    }

}

