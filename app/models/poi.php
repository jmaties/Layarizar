<?php
class Poi extends AppModel
{
    var $useTable = 'POI';
    //var $primarykey = 'id';
	var $actsAs = array(    'Containable',
				'Action',
						
			    	'Uploader.Attachment' => array(
					'file' => array(
						'uploadDir' 	=> '/files/base/',	// Where to upload to, relative to app webroot
						'dbColumn'	=> '',	// The database column name to save the path to
						'maxNameLength'	=> 60,		// Max file name length
						'overwrite'	=> true,	// Overwrite file with same name if it exists
						'name'		=> '',		// The name to give the file (should be done right before a save)
						'transforms' 	=> array('resize' => array('width' => 100, 'height' => 75, 'dbColumn' => 'imageURL'))	// 'resize' => array('width' => 100, 'height' => 75, 'dbColumn' => 'imageURL')
						)
						)
);
    var $validate = array(
        'lat' => array(
            'rule' => 'notEmpty',
            'message' => 'La latitud no puede estar vacia.',
        ),
		'lon' => array(
            'rule' => 'notEmpty',
            'message' => 'La longitud no puede estar vacia.',
        ),
	'title' => array(
            'rule' => 'notEmpty',
            'message' => 'El titulo no puede estar vacio.',
        ),
        'typo' => array(
            'rule' => 'notEmpty',
            'message' => 'El tipo no puede estar vacio.',
        ),
    );
    var $hasMany = array(
        'Action' => array(
            'className' => 'Action',
            'foreignKey' => 'poiId',
            'dependent' => true,
            'conditions' => '', //array('Action.autoTriggerOnly' => 0)
            'fields' => '',
            'order' => 'Action.label ASC',
            'limit' => '5',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        )
        );
}
?>