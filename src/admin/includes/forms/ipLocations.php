<?php

$form = formBuilder::createForm('ipLocations');
$form->linkToDatabase(array(
    'table'       => 'ipLocations',
    'order'       => 'name'
));

$form->insertTitle = "New IP Ranges";
$form->editTitle   = "Edit IP Ranges";


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
        'label' => 'IP Location',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

$form->addField(
    array(
        'name'  => 'ipRange',
        'label' => 'IP Range',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

?>