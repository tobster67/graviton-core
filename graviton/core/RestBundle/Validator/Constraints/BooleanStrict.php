<?php
/**
 * Constraint for a strict boolean check (not accepting integers of any kind)
 */

namespace Graviton\RestBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for a strict boolean check (not accepting integers of any kind)
 *
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class BooleanStrict extends Constraint
{

    /**
     * Error message
     *
     * @var string
     */
    public $message = 'The value "%string%" is not a valid boolean.';
}
