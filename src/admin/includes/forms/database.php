<?php

$form = formBuilder::createForm('Database');
$form->linkToDatabase(array(
    'table'       => 'dbList'
));

$form->insertTitle = "New Database";
$form->editTitle   = "Edit Database";

$processor = formBuilder::createProcessor();

global $databaseID;

$form->addField(
    array(
        'name'            => 'ID',
        'primary'         => TRUE,
        'showIn'          => array(formBuilder::TYPE_INSERT, formBuilder::TYPE_UPDATE),
        'type'            => 'hidden',
        'value'           => $databaseID,
    )
);

$form->addField(
    array(
        'name'            => 'createDate',
        'showIn'          => array(formBuilder::TYPE_INSERT),
        'type'            => 'hidden',
        'value'           => time(),
    )
);

$form->addField(
    array(
        'name'            => 'updateDate',
        'showIn'          => array(formBuilder::TYPE_INSERT, formBuilder::TYPE_UPDATE),
        'type'            => 'hidden',
        'value'           => time(),
    )
);

$form->addField(
    array(
        'name'            => 'URLID',
        'showIn'          => array(formBuilder::TYPE_INSERT),
        'type'            => 'hidden',
        'value'           => time(),
    )
);

$form->addField(
	array(
		'name'       => 'name',
		'label'      => 'Database Name',
		'required'   => TRUE,
		'duplicates' => FALSE
		)
	);

$form->addField(
	array(
		'name'     => 'status',
		'label'    => 'Status',
		'type'     => 'select',
		'required' => TRUE,
		'options'  => array(
			"NULL"    => "-- Select One --",
			"1"       => "Production",
			"2"       => "Development",
			"3"       => "Hidden"
			)
		)
	);

$form->addField(
	array(
		'name'  => 'yearsOfCoverage',
		'label' => 'Years of Coverage'
		)
	);

// $form->addField(
// 	array(
// 		'name'        => 'vendor',
// 		'label'       => 'Vendor',
// 		'type'        => "select",
// 		'blankOption' => "-- Select a Vendor --",
// 		'linkedTo'    => array(
// 			'foreignTable' => 'vendors',
// 			'foreignKey'   => 'ID',
// 			'foreignLabel' => 'name'
// 			)
// 		)
// 	);

$form->addField(
	array(
		'name'       => 'url',
		'label'      => 'Database URL',
		// 'type'       => "url",
		'required'   => TRUE,
		'duplicates' => FALSE
		)
	);

// $form->addField(
// 	array(
// 		'name'  => 'offCampusURL',
// 		'label' => 'Datbase URL (Off Campus)',
// 		'type'  => "url"
// 		)
// 	);

// $form->addField(
// 	array(
// 		'name'     => 'updated',
// 		'label'    => 'Updated',
// 		'type'     => "select",
// 		'blankOption' => '-- Select One --',
// 		'linkedTo'    => array(
// 			'foreignTable' => 'updateText',
// 			'foreignKey'   => 'ID',
// 			'foreignLabel' => 'name'
// 			)
// 		)
// 	);

$form->addField(
	array(
		'name'  => 'popular',
		'label' => 'Popular Database',
		'type'  => 'boolean'
		)
	);

// $form->addField(
// 	array(
// 		'name'  => 'fullTextDB',
// 		'label' => 'Full Text',
// 		'type'  => 'boolean'
// 		)
// 	);

$form->addField(
	array(
		'name'  => 'newDatabase',
		'label' => 'New Database',
		'type'  => 'boolean'
		)
	);

$form->addField(
	array(
		'name'  => 'alumni',
		'label' => 'Alumni Datbaase',
		'type'  => 'boolean'
		)
	);

$form->addField(
	array(
		'name'  => 'trialDatabase',
		'label' => 'Trial Database',
		'type'  => 'boolean'
		)
	);

$form->addField(
	array(
		'name'     => 'trialExpireDate',
		'label'    => 'Trial Expiration Date',
		'type'     => 'date',
		'placeholder' => "MM/DD/YYYY",
		'help'     => array( 
			'type' => "hover",
			'text' => "Must be a date in the format of mm/dd/yyyy"
			)
		)
	);

$form->addField(
	array(
		'name'        => 'access',
		'label'       => 'Access (Plain Text)',
		'type'        => "select",
		'required'    => TRUE,
		'blankOption' => '-- Select One --',
		'value'       => '48',
		'linkedTo'    => array(
			'foreignTable' => 'accessPlainText',
			'foreignKey'   => 'ID',
			'foreignLabel' => 'name'
			)
		)
		
	);

$form->addField(
	array(
		'name'     => 'accessType',
		'label'    => 'Access Type',
		'type'     => "select",
		'required' => TRUE,
		'blankOption' => '-- Select One --',
		'value'       => '2',
		'linkedTo'    => array(
			'foreignTable' => 'accessTypes',
			'foreignKey'   => 'ID',
			'foreignLabel' => 'name'
			)
		)
		
	);

$form->addField(
	array(
		'name'  => 'help',
		'label' => 'Help (text)',
		'type'  => 'textarea',
		'value' => "Ask a Librarian"
		)
	);

$form->addField(
	array(
		'name'  => 'helpURL',
		'label' => 'Help (URL)',
		'type'  => 'textarea',
		'value' => 'http://westvirginia.libanswers.com/'
		)
	);

$form->addField(
	array(
		'name'     => 'description',
		'label'    => 'Description',
		'type'     => 'textarea',
		'required' => TRUE
		)
	);

$form->addField(
	array(
		'name'  => 'resourceTypes',
		'label' => 'Resource Types',
		'type'  => 'multiselect',
		'linkedTo'    => array(
			'foreignTable'     => 'resourceTypes',
			'foreignKey'       => 'ID',
			'foreignLabel'     => 'name',
			'linkTable'        => 'databases_resourceTypes',
			'linkLocalField'   => 'dbID',
			'linkForeignField' => 'resourceID'
			)
		)
	);

$form->addField(
	array(
		'name'  => 'subjects',
		'label' => 'Subjects',
		'type'  => 'multiselect',
		'linkedTo'    => array(
			'foreignTable'     => 'subjects',
			'foreignKey'       => 'ID',
			'foreignLabel'     => 'name',
			'linkTable'        => 'databases_subjects',
			'linkLocalField'   => 'dbID',
			'linkForeignField' => 'subjectID'
			)
		)
	);

$form->addField(
	array(
		'name'  => 'curated',
		'label' => 'Curated',
		'type'  => 'multiselect',
		'linkedTo'    => array(
			'foreignTable'     => 'subjects',
			'foreignKey'       => 'ID',
			'foreignLabel'     => 'name',
			'linkTable'        => 'databases_curated',
			'linkLocalField'   => 'dbID',
			'linkForeignField' => 'subjectID'
			)
		)
	);



?>