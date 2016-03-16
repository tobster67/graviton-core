<?php
/**
 * test security contract (mainly getters and defaults)
 */

namespace Graviton\SecurityBundle\Entities;

use Graviton\TestBundle\Test\WebTestCase;

/**
 * Class SecurityContractTest
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class SecurityUserTest extends WebTestCase
{
    /**
     * @param string[] $methods methods to mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Graviton\SecurityBundle\Entities\SecurityUser
     */
    protected function getUserMock(array $methods = array())
    {
        return $this->getMockBuilder('\Graviton\SecurityBundle\Entities\SecurityUser')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    /**
     * roles should always return an array
     *
     * @return void
     */
    public function testGetRoles()
    {
        $entity = new SecurityUser($this->getUserMock());

        $this->assertInternalType('array', $entity->getRoles());
    }

    /**
     * get password should return empty
     *
     * @return void
     */
    public function testGetPassword()
    {
        $entity = new SecurityUser($this->getUserMock());

        $this->assertEmpty($entity->getPassword());
    }

    /**
     * get salt should return empty
     *
     * @return void
     */
    public function testGetSalt()
    {
        $entity = new SecurityUser($this->getUserMock());

        $this->assertEmpty($entity->getSalt());
    }

    /**
     * test credential removal
     *
     * @return void
     */
    public function testEraseCredentials()
    {
        $entity = new SecurityUser($this->getUserMock());

        $this->assertEmpty($entity->eraseCredentials());
    }
}
