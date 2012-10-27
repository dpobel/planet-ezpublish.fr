<?php

use eZ\Bundle\EzPublishCoreBundle\EzPublishCoreBundle,
    eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle,
    eZ\Bundle\EzPublishRestBundle\EzPublishRestBundle,
    EzSystems\DemoBundle\EzSystemsDemoBundle,
    Symfony\Bundle\FrameworkBundle\FrameworkBundle,
    Symfony\Bundle\SecurityBundle\SecurityBundle,
    Symfony\Bundle\TwigBundle\TwigBundle,
    Symfony\Bundle\AsseticBundle\AsseticBundle,
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle,
    Symfony\Component\Config\Loader\LoaderInterface,
    Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;


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
            new EzSystemsDemoBundle(),
            new EzPublishLegacyBundle(),
            new EzPublishRestBundle()
        );

        if ( $this->getEnvironment() === 'dev' )
        {
            $bundles[] = new WebProfilerBundle();
        }

        return $bundles;
    }
}
