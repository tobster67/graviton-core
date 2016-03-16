<?php
/**
 * manage and load bundle config.
 */

namespace Graviton\CoreBundle\DependencyInjection;

use Graviton\BundleBundle\DependencyInjection\GravitonBundleExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://scm.to/004w}
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class GravitonCoreExtension extends GravitonBundleExtension
{
    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getConfigDir()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * @param array            $configs   parameters configuration
     * @param ContainerBuilder $container Symfony container
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Load configs for Dynamic Bundles
        parent::load($configs, $container);
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        if( isset($configs[0]['service_name'])) {
            $container->setParameter('graviton.core.links', $configs[0]['service_name']);
        }
        if( isset($configs[0]['uri_whitelist'])) {
            $container->setParameter('graviton.core.main.path.whitelist', $configs[0]['uri_whitelist']);
        }
    }
}
