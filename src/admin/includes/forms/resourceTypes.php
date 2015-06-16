<?php

$form = formBuilder::createForm('ResourceTypes');
$form->linkToDatabase(array(
    'table'       => 'resourceTypes'
));

$form->insertTitle = "New Resource Type";
$form->editTitle   = "Edit Resource Types";


$form->addField(
    array(
        'name'            => 'ID',
        'primary'         => TRUE,
        'showIn'          => array(formBuilder::TYPE_INSERT, formBuilder::TYPE_UPDATE),
        'type'            => 'hidden'
    )
);

$form->addField(
    array(
        'name'  => 'name',
        'label' => 'Resource Types'
    )
);


?>