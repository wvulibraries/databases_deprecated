<?php

$form = formBuilder::createForm('Subjects');
$form->linkToDatabase(array(
    'table'       => 'subjects',
    'order'       => 'name'
));

$form->insertTitle = "New Subject";
$form->editTitle   = "Edit Subjcets";
$form->submitFieldCSSEdit = "display: none;";

$form->addField(
    array(
        'name'            => 'ID',
        'primary'         => TRUE,
        'type'            => 'hidden'
    )
);

$form->addField(
    array(
        'name'  => 'name',
        'label' => 'Subject',
        'required'   => TRUE,
        'showIn'          => array(formBuilder::TYPE_INSERT, formBuilder::TYPE_EDIT,formBuilder::TYPE_UPDATE),
        'duplicates' => FALSE
    )
);

$form->addField(
    array(
        'name'  => 'url',
        'label' => 'Subject URL',
        'showIn'          => array(formBuilder::TYPE_INSERT, formBuilder::TYPE_UPDATE),
        'type'  => 'url'
    )
);

$form->addField(
    array(
        'name'   => "orderCuratedDatabases",
        'label'  => "Order Curated DBs",
        'type'   => "plainText",
        'value'  => sprintf('<a href="order/?id={ID}">Edit</a>'),
        'showIn' => array(formBuilder::TYPE_EDIT)
        )
    );

    $form->addField(
    	array(
    		'name'  => 'databases',
    		'label' => 'Databases',
    		'type'  => 'multiselect',
    		'linkedTo'    => array(
    			'foreignTable'     => 'dbList',
    			'foreignKey'       => 'ID',
    			'foreignLabel'     => 'name',
    			'linkTable'        => 'databases_subjects',
    			'linkLocalField'   => 'subjectID',
    			'linkForeignField' => 'dbID'
        ),
        'showIn' => array(formBuilder::TYPE_UPDATE)
    		)
    	);

?>
