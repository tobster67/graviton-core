<?php
/**
 * RqlFieldsCompilerPass class file
 */

namespace Graviton\DocumentBundle\DependencyInjection\Compiler;

use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\Document;
use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\DocumentMap;
use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\ArrayField;
use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\EmbedMany;
use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\EmbedOne;
use Graviton\DocumentBundle\DependencyInjection\Compiler\Utils\Field;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class RqlFieldsCompilerPass implements CompilerPassInterface
{
    /**
     * @var DocumentMap
     */
    private $documentMap;

    /**
     * Constructor
     *
     * @param DocumentMap $documentMap Document map
     */
    public function __construct(DocumentMap $documentMap)
    {
        $this->documentMap = $documentMap;
    }

    /**
     * Make extref fields map and set it to parameter
     *
     * @param ContainerBuilder $container container builder
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $map = [];

        $services = array_keys($container->findTaggedServiceIds('graviton.rest'));
        foreach ($services as $id) {
            list($ns, $bundle, , $doc) = explode('.', $id);
            if (empty($bundle) || empty($doc)) {
                continue;
            }

            $className = $this->getServiceDocument(
                $container->getDefinition($id),
                $ns,
                $bundle,
                $doc
            );
            $rqlFields = $this->processDocument($this->documentMap->getDocument($className));
            $routePrefix = strtolower($ns.'.'.$bundle.'.'.'rest'.'.'.$doc);

            $map[$routePrefix.'.get'] = $rqlFields;
            $map[$routePrefix.'.all'] = $rqlFields;
        }

        $container->setParameter('graviton.document.rql.fields', $map);
    }

    /**
     * Get document class name from service
     *
     * @param Definition $service Service definition
     * @param string     $ns      Bundle namespace
     * @param string     $bundle  Bundle name
     * @param string     $doc     Document name
     * @return string
     */
    private function getServiceDocument(Definition $service, $ns, $bundle, $doc)
    {
        $tags = $service->getTag('graviton.rest');
        if (!empty($tags[0]['collection'])) {
            $doc = $tags[0]['collection'];
            $bundle = $tags[0]['collection'];
        }

        if (strtolower($ns) === 'gravitondyn') {
            $ns = 'GravitonDyn';
        }

        return sprintf(
            '%s\\%s\\Document\\%s',
            ucfirst($ns),
            ucfirst($bundle).'Bundle',
            ucfirst($doc)
        );
    }

    /**
     * Recursive doctrine document processing
     *
     * @param Document $document       Document
     * @param string   $documentPrefix Document field prefix
     * @param string   $exposedPrefix  Exposed field prefix
     * @return array
     */
    private function processDocument(Document $document, $documentPrefix = '', $exposedPrefix = '')
    {
        $result = [];
        foreach ($document->getFields() as $field) {
            $result[$documentPrefix.$field->getFieldName()] = $exposedPrefix.$field->getExposedName();

            if ($field instanceof ArrayField) {
                $result[$documentPrefix.$field->getFieldName().'.0'] = $exposedPrefix.$field->getExposedName().'.0';
            } elseif ($field instanceof EmbedOne) {
                $result = array_merge(
                    $result,
                    $this->processDocument(
                        $field->getDocument(),
                        $documentPrefix.$field->getFieldName().'.',
                        $exposedPrefix.$field->getExposedName().'.'
                    )
                );
            } elseif ($field instanceof EmbedMany) {
                $result[$documentPrefix.$field->getFieldName().'.0'] = $exposedPrefix.$field->getExposedName().'.0';
                $result = array_merge(
                    $result,
                    $this->processDocument(
                        $field->getDocument(),
                        $documentPrefix.$field->getFieldName().'.0.',
                        $exposedPrefix.$field->getExposedName().'.0.'
                    )
                );
            }
        }

        return $result;
    }
}
