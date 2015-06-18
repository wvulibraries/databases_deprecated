<?php

$form = formBuilder::createForm('Vendors');
$form->linkToDatabase(array(
    'table'       => 'vendors'
));

$form->insertTitle = "New Vendor";
$form->editTitle   = "Edit Vendors";


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
        'label' => 'Vendor',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

$form->addField(
    array(
        'name'  => 'url',
        'label' => 'Vendor URL',
        'type'  => 'url',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

?>