<?php
/**
 * Basic functional test for CoreVersionUtils class
 */

namespace Graviton\CoreBundle\Tests\Service;

use Graviton\CoreBundle\Service\CoreVersionUtils;
use Graviton\TestBundle\Test\RestTestCase;

/**
 * @category GravitonCoreBundle
 * @package  Graviton
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class CoreVersionUtilsTest extends RestTestCase
{
    /**l
     * @var CoreVersionUtils
     */
    private $coreVersionUtils;

    /**
     * @dataProvider provideVersionStringForGet
     *
     * @param string $versionString   String which should be checked
     * @param string $expectedVersion Expected Version string
     * @return void
     */
    public function testGetVersionNumber($versionString, $expectedVersion)
    {
        $yamlDumper = $this->getMockBuilder('Symfony\Component\Yaml\Dumper')
            ->getMock();

        $this->coreVersionUtils = new CoreVersionUtils(
            'composer',
            $this->getContainer()->getParameter('kernel.root_dir'),
            $yamlDumper
        );

        $returnedVersion = $this->coreVersionUtils->getVersionNumber($versionString);
        $this->assertEquals($expectedVersion, $returnedVersion);
    }

    /**
     * Data provider for testGetVersionNumber
     *
     * @return array
     */
    public function provideVersionStringForGet()
    {
        return array(
            array('1.2.3.4', 'v1.2.3'),
            array('1.2.3', '1.2.3'),
            array('v1.2.3', 'v1.2.3'),
            array('v1.2.3-alpha1', 'v1.2.3'),
            array('dev-feature/test_branch', 'dev-feature/test_branch'),
            array('dev-9d0b8cf7c7a607684e978a2777ebdd36e348ba75', 'dev-9d0b8cf7c7a607684e978a2777ebdd36e348ba75'),
            array('No version set (parsed as 1.0.0)', 'No version set (parsed as 1.0.0)')
        );
    }
}
