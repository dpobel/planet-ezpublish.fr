<?php

use eZ\Bundle\EzPublishCoreBundle\EzPublishCoreBundle;
use Egulias\ListenersDebugCommandBundle\EguliasListenersDebugCommandBundle;
use eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle;
use eZ\Bundle\EzPublishRestBundle\EzPublishRestBundle;
use Planet\PlanetBundle\PlanetBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;
use Tedivm\StashBundle\TedivmStashBundle;

class PlanetKernel extends EzPublishKernel
{

    public function registerBundles()
    {
        $bundles = array(
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new MonologBundle(),
            new AsseticBundle(),
            new SensioGeneratorBundle(),
            new TedivmStashBundle(),
            new EzPublishCoreBundle(),
            new EzPublishLegacyBundle(),
            new EzPublishRestBundle(),
            new PlanetBundle(),
        );

        if ( $this->getEnvironment() === 'dev' )
        {
            $bundles[] = new WebProfilerBundle();
            $bundles[] = new EguliasListenersDebugCommandBundle();
        }

        return $bundles;
    }
}
