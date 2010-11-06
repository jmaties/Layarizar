<?php
/**
 * Action Helper
 *
 * PHP version 5
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class ActionHelper extends AppHelper {
/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    var $helpers = array('Html', 'Form');
/**
 * Action with key/value fields
 *
 * @param string $key (optional) key
 * @param string $value (optional) value
 * @param integer $id (optional) ID of Action
 * @param array $options (optional) options
 * @return string
 */
    function field($key = '', $value = null, $trigger = '0' ,$id = null, $options = array()) {
	//print '<br/>KEY: '.$key.'<br/>URI: '.$value.'<br/>ID: '.$id.'</br>TRIGGER: '.$trigger;
        $_options = array(
            'key'   => array(
                'label'   => __('Label', true),
                'value'   => $key,
            ),
            'value' => array(
                'label'   => __('Uri', true),
                'value'   => $value,
            ),
	    'trigger' => array(
                'legend'   => __('Auto Inicio', true),
                'value'   => $trigger,
		'type' => 'radio',
                'div' => array('class' => 'radio'),
		'options' => array(
                            '0' => __('Manual', true),
                            '1' => __('Automatico', true)
                        ),
            ),
        );
        $options = array_merge($_options, $options);
        $uuid = String::uuid();

        $fields  = '';
        if ($id != null) {
            $fields .= $this->Form->input('Action.'.$uuid.'.id', array('type' => 'hidden', 'value' => $id));
        }
        $fields .= $this->Form->input('Action.'.$uuid.'.label', $options['key']);
        $fields .= $this->Form->input('Action.'.$uuid.'.uri', $options['value']);
		$fields .= $this->Form->input('Action.'.$uuid.'.autoTriggerOnly', $options['trigger']);
        $fields = $this->Html->tag('div', $fields, array('class' => 'fields'));

        $actions = $this->Html->link(__('Eliminar', true), '#', array('class' => 'remove-action', 'rel' => $id), null, null, false);
        $actions = $this->Html->tag('div', $actions, array('class' => 'actions'));

        $output = $this->Html->tag('div', $actions . $fields, array('class' => 'meta'));
        return $output;
    }

}
?>