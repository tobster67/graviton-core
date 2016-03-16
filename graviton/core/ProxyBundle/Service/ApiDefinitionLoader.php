<?php
/**
 * ApiDefinitionLoader
 */

namespace Graviton\ProxyBundle\Service;

use Graviton\ProxyBundle\Definition\ApiDefinition;
use Graviton\ProxyBundle\Definition\Loader\LoaderInterface;

/**
 * load API definition from  a external source
 *
 * @package Graviton\ProxyBundle\Service
 * @author  List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link    http://swisscom.ch
 */
class ApiDefinitionLoader
{
    /**
     * @var string
     */
    const PROXY_ROUTE = "3rdparty";

    /**
     * @var LoaderInterface
     */
    private $definitionLoader;

    /**
     * @var array
     */
    private $options;

    /**
     * @var ApiDefinition
     */
    private $definition;

    /**
     * set loader
     *
     * @param LoaderInterface $loader loader
     *
     * @return void
     */
    public function setDefinitionLoader($loader)
    {
        $this->definitionLoader = $loader;
    }

    /**
     * set options for the loader
     *
     * @param array $options options [uri, prefix]
     *
     * @return void
     */
    public function setOption(array $options)
    {
        $this->options = $options;
        if (!empty($this->definitionLoader)) {
            $this->definitionLoader->setOptions($options);
        }
    }

    /**
     * get the origin service definition
     *
     * @param bool $forceReload Switch to force a new api definition object will be provided.
     *
     * @return mixed the origin service definition (type depends on dispersal strategy)
     */
    public function getOriginDefinition($forceReload = false)
    {
        $this->loadApiDefinition($forceReload);

        return $this->definition->getOrigin();
    }

    /**
     * get a schema for one endpoint
     *
     * @param string $endpoint    endpoint
     * @param bool   $forceReload Switch to force a new api definition object will be provided.
     *
     * @return \stdClass
     */
    public function getEndpointSchema($endpoint, $forceReload = false)
    {
        $this->loadApiDefinition($forceReload);

        return $this->definition->getSchema($endpoint);
    }

    /**
     * get an endpoint
     *
     * @param string  $endpoint    endpoint
     * @param boolean $withHost    attach host name to the url
     * @param bool    $forceReload Switch to force a new api definition object will be provided.
     *
     * @return string
     */
    public function getEndpoint($endpoint, $withHost = false, $forceReload = false)
    {
        $this->loadApiDefinition($forceReload);
        $url = "";
        if ($withHost) {
            $url = empty($this->options['host']) ? $this->definition->getHost() : $this->options['host'];
        }

        // If the base path is not already included, we need to add it.
        $url .= (empty($this->options['includeBasePath']) ? $this->definition->getBasePath() : '') . $endpoint;

        return $url;
    }

    /**
     * get all endpoints for an API
     *
     * @param boolean $withHost    attach host name to the url
     * @param bool    $forceReload Switch to force a new api definition object will be provided.
     *
     * @return array
     */
    public function getAllEndpoints($withHost = false, $forceReload = false)
    {
        $this->loadApiDefinition($forceReload);

        $host = empty($this->options['host']) ? '' : $this->options['host'];
        $prefix = self::PROXY_ROUTE;
        if (isset($this->options['prefix'])) {
            $prefix .= "/".$this->options['prefix'];
        }

        return !is_object($this->definition) ? [] : $this->definition->getEndpoints(
            $withHost,
            $prefix,
            $host,
            !empty($this->options['includeBasePath'])
        );
    }

    /**
     * internal load method
     *
     * @param bool $forceReload Switch to force a new api definition object will be provided.
     *
     * @return void
     */
    private function loadApiDefinition($forceReload = false)
    {
        $supported = $this->definitionLoader->supports($this->options['uri']);

        if ($forceReload || ($this->definition == null && $supported)) {
            $this->definition = $this->definitionLoader->load($this->options['uri']);
        } elseif (!$supported) {
            throw new \RuntimeException("This resource (".$this->options['uri'].") is not supported.");
        }
    }
}
