<?php

use eZ\Bundle\EzPublishCoreBundle\EzPublishCoreBundle,
    eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle,
    Planet\PlanetBundle\PlanetBundle,
    Symfony\Bundle\FrameworkBundle\FrameworkBundle,
    Symfony\Bundle\SecurityBundle\SecurityBundle,
    Symfony\Bundle\TwigBundle\TwigBundle,
    Symfony\Bundle\AsseticBundle\AsseticBundle,
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle,
    Symfony\Component\Config\Loader\LoaderInterface,
    Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;

require_once __DIR__ . '/EzPublishKernel.php';

class PlanetKernel extends EzPublishKernel
{

    public function registerBundles()
    {
        $bundles = array(
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new AsseticBundle(),
            new SensioGeneratorBundle(),
            new EzPublishCoreBundle(),
            new EzPublishLegacyBundle(),
            new PlanetBundle(),
        );

        if ( $this->getEnvironment() === 'dev' )
        {
            $bundles[] = new WebProfilerBundle();
        }

        return $bundles;
    }
}
