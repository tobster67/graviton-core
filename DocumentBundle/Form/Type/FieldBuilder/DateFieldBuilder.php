<?php
/**
 * DateFieldBuilder class file
 */

namespace Graviton\DocumentBundle\Form\Type\FieldBuilder;

use Graviton\DocumentBundle\Form\Type\DocumentType;
use Symfony\Component\Form\FormInterface;

/**
 * @author   List of contributors <https://github.com/libgraviton/graviton/graphs/contributors>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://swisscom.ch
 */
class DateFieldBuilder implements FieldBuilderInterface
{
    /**
     * Is field type supported by this builder
     *
     * @param string $type    Field type
     * @param array  $options Options
     * @return bool
     */
    public function supportsField($type, array $options = [])
    {
        return $type === 'date' || $type === 'datetime';
    }

    /**
     * Build form field
     *
     * @param DocumentType  $document      Document type
     * @param FormInterface $form          Form
     * @param string        $name          Field name
     * @param string        $type          Field type
     * @param array         $options       Options
     * @param mixed         $submittedData Submitted data
     * @return void
     */
    public function buildField(
        DocumentType $document,
        FormInterface $form,
        $name,
        $type,
        array $options = [],
        $submittedData = null
    ) {
        $options['widget'] = 'single_text';
        $options['input'] = 'datetime';

        $form->add($name, $type, $options);
    }
}
