<?php
/**
 * core infrastructure like logging and framework.
 */

namespace Graviton\CoreBundle;

use Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle;
use Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle;
use Eo\AirbrakeBundle\EoAirbrakeBundle;
use Exercise\HTMLPurifierBundle\ExerciseHTMLPurifierBundle;
use Graviton\BundleBundle\GravitonBundleBundle;
use Graviton\BundleBundle\GravitonBundleInterface;
use Graviton\BundleBundle\Loader\BundleLoader;
use Graviton\CoreBundle\Compiler\EnvParametersCompilerPass;
use Graviton\DocumentBundle\GravitonDocumentBundle;
use Graviton\GeneratorBundle\GravitonGeneratorBundle;
use Graviton\I18nBundle\GravitonI18nBundle;
use Graviton\JsonSchemaBundle\GravitonJsonSchemaBundle;
use Graviton\RabbitMqBundle\GravitonRabbitMqBundle;
use Graviton\ProxyBundle\GravitonProxyBundle;
use Graviton\RestBundle\GravitonRestBundle;
use Graviton\RqlParserBundle\GravitonRqlParserBundle;
use Graviton\SchemaBundle\GravitonSchemaBundle;
use Graviton\SecurityBundle\GravitonSecurityBundle;
use Graviton\SwaggerBundle\GravitonSwaggerBundle;
use Graviton\FileBundle\GravitonFileBundle;
use HadesArchitect\JsonSchemaBundle\JsonSchemaBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Knp\Bundle\GaufretteBundle\KnpGaufretteBundle;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Misd\GuzzleBundle\MisdGuzzleBundle;
use OldSound\RabbitMqBundle\OldSoundRabbitMqBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Graviton\CoreBundle\Compiler\VersionCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * GravitonCoreBundle
 *
 * WARNING: Don't change me without changing Graviton\GeneratorBundle\Manipulator\BundleBundleManipulator
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 *
 * @see \Graviton\GeneratorBundle\Manipulator\BundleBundleManipulator
 */
class GravitonCoreBundle extends Bundle implements GravitonBundleInterface
{
    /**
     * {@inheritDoc}
     *
     * set up graviton symfony bundles
     *
     * @return \Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    public function getBundles()
    {
        // the regular needed bundles
        $BundleArray = array(
            new DoctrineCacheBundle(),
            new DoctrineMongoDBBundle(),
            new StofDoctrineExtensionsBundle(),
            new MisdGuzzleBundle(),
            new ExerciseHTMLPurifierBundle(),
            new KnpGaufretteBundle(),
            new EoAirbrakeBundle(),
            new SensioFrameworkExtraBundle(),
            new OldSoundRabbitMqBundle(),
            new JMSSerializerBundle(),
            new KnpPaginatorBundle(),
            new JsonSchemaBundle(),
            new GravitonRabbitMqBundle(),
            new GravitonProxyBundle(),
            new GravitonDocumentBundle(),
            new GravitonI18nBundle(),
            new GravitonSchemaBundle(),
            new GravitonRqlParserBundle(),
            new GravitonSecurityBundle(),
            new GravitonSwaggerBundle(),
            new GravitonRestBundle(),
            new GravitonFileBundle(),
            new GravitonJsonSchemaBundle(),
            new GravitonGeneratorBundle(),
        );
        // loading the Dynamic Bundles
        $BundleLoader = new BundleLoader(new GravitonBundleBundle());
        $BundleArray = $BundleLoader->load($BundleArray);
        return $BundleArray;
    }

    /**
     * load version compiler pass
     *
     * @param ContainerBuilder $container container builder
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new VersionCompilerPass());
        $container->addCompilerPass(new EnvParametersCompilerPass());
    }
}
