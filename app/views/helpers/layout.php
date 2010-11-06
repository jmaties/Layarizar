<?php
/**
 * Layout Helper
 *
 * PHP version 5
 *
 * @category Helper
 */
class LayoutHelper extends AppHelper {
/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    var $helpers = array(
        'Html',
        'Form',
        'Session',
        'Javascript',
    );
/**
 * Current Node
 *
 * @var array
 * @access public
 */
    var $node = null;
/**
 * Hook helpers
 *
 * @var array
 * @access public
 */
    var $hooks = array();
/**
 * Constructor
 *
 * @param array $options options
 * @access public
 */
    function __construct($options = array()) {
        $this->View =& ClassRegistry::getObject('view');

        return parent::__construct($options);
    }

/**
 * Javascript variables
 *
 * @return string
 */
    function js() {
        $output = $this->Javascript->link('layar');

        $layar = array();
        $layar['basePath'] = Router::url('/');
        $layar['params'] = array(
            'controller' => $this->params['controller'],
            'action' => $this->params['action'],
            'named' => $this->params['named'],
        );
        $output .= $this->Javascript->codeBlock('$.extend(Layar, ' . $this->Javascript->object($layar) . ');');

        echo $output;
    }
}
?>