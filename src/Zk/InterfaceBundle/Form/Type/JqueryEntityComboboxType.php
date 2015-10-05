<?php

namespace Zk\InterfaceBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Render a Jquery Combobox Select of an entity
 * Important: you must include combobox.js to enable this widget
 */

class JqueryEntityComboboxType extends EntityType
{
    public function getName()
    {
        return "jquery_entity_combobox";
    }

  //public function getDefaultOptions(array $options)
  //{
  //  $options = parent::getDefaultOptions($options);
  //  $options['multiple'] = false;
  //
  //  //DEFAULT VALUE = NULL
  //  $options['empty_value'] = "";
  //  return $options;
  //}
}
