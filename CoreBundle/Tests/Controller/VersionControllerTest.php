<?php
/**
 * functional test for /core/version
 */

namespace Graviton\CoreBundle\Tests\Controller;

use Graviton\TestBundle\Test\RestTestCase;

/**
 * Basic functional test for /core/config.
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class VersionControllerTest extends RestTestCase
{

    /**
     * Tests if get request returns data in right schema format
     *
     * @return void
     */
    public function testVersionsAction()
    {
        $client = static::createRestClient();
        $client->request('GET', '/core/version');
        $response = $client->getResponse();

        $this->assertContains('"self":', $response->getContent());
        $this->assertInternalType('string', $response->getContent());

        $tagRegExp = '^([v]?[0-9]+\.[0-9]+\.[0-9]+)(-[0-9a-zA-Z.]+)?(\+[0-9a-zA-Z.]+)?$';
        $branchRegExp = '^((dev\-){1}[0-9a-zA-Z\.\/\-\_]+)$';
        $regExp = sprintf('/%s|%s/', $tagRegExp, $branchRegExp);

        $content = json_decode($response->getContent());
        foreach ($content->versions as $packageId => $packageVersion) {
            $this->assertRegExp($regExp, $packageVersion);
        }
    }

    /**
     * Tests if schema returns the right values
     *
     * @return void
     */
    public function testVersionsSchemaAction()
    {
        $client = static::createRestClient();
        $client->request('GET', '/schema/core/version');
        $response = $client->getResponse();

        $this->assertEquals(
            '{"title":"Version","description":"Reveals version numbers of configured packages",'.
            '"type":"object","properties":{"versions":{"title":"versions","description":"Object of versions",'.
            '"additionalProperties":{"title":"Version Number","description":"The actual version","type":"string"}}}}',
            $response->getContent()
        );
        $this->assertInternalType('string', $response->getContent());
    }
}
