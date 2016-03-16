<?php
/**
 * Load and manage bundle configuration.
 */

namespace Graviton\BundleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface as PrependInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * GravitonBundleExtension
 *
 * To learn more see {@link http://scm.to/004w}
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class GravitonBundleExtension extends Extension implements PrependInterface
{
    /**
     * {@inheritDoc}
     *
     * @param array            $configs   configs to process
     * @param ContainerBuilder $container container to use
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader(
            $container,
            new FileLocator($this->getConfigDir())
        );
        $loader->load('services.xml');
    }

    /**
     * get path to bundles Resources/config dir
     *
     * @return string
     */
    public function getConfigDir()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * {@inheritDoc}
     *
     * Load additional config into the container.
     *
     * @param ContainerBuilder $container instance
     *
     * @return void
     */
    public function prepend(ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator($this->getConfigDir())
        );
        if( file_exists($this->getConfigDir().'/parameters.yml')) {
            $loader->load('parameters.yml');
        }
        if( file_exists($this->getConfigDir().'/config.yml')) {
            $loader->load('config.yml');
        }

        $loader = new Loader\XmlFileLoader(
            $container,
            new FileLocator($this->getConfigDir())
        );
        $loader->load('config.xml');

    }

    /**
     * Returns extension configuration.
     *
     * @param array                                                   $config    An array of configuration values
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container A ContainerBuilder instance
     *
     * @return \Symfony\Component\Config\Definition\ConfigurationInterface
     * @throws \RuntimeException
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $configuration = parent::getConfiguration($config, $container);

        if ($configuration instanceof ConfigurationInterface) {
            return $configuration;
        }

        throw new \RuntimeException('Expected configuration class not found!');
    }
}
