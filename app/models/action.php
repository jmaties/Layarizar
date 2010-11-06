<?php
class Action extends AppModel
{
    var $name = 'Action';
    var $useTable = 'Action';
	//var $primarykey = 'idact';
    var $belongsTo = array('Poi' =>
                           array('className'=> 'Poi',
                                'foreignKey' => 'poiId',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                 )
                          );
}
?>