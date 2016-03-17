# Graviton Core Bundles
This is the collection of the Graviton Core Bundles for Symfony

it can be required by the composer and resides in the vendor,
or it can reside in a directory i.e. src

## Installation
### as a vendor lib
Require it in composer.json and do a composer update
### in a Symfony Standard app
add this git as submodule to the required path
### Register it in the Kernel`
in registerBundles i.e.
```
...
$bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new AppBundle\AppBundle(),
        );
        // intialize GravitonCoreBundle with all dependend Bundles
        $GravitonCoreBundle = new Graviton\CoreBundle\GravitonCoreBundle();
        $bundles[] = $GravitonCoreBundle;
        $bundles = array_merge( $bundles, $GravitonCoreBundle->getBundles() );
...
```
### Configure the routing
tbd
### Configure the Views
tbd


