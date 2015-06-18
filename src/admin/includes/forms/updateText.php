<?php

$form = formBuilder::createForm('UpdateText');
$form->linkToDatabase(array(
    'table'       => 'updateText'
));

$form->insertTitle = "New Update Text";
$form->editTitle   = "Edit Update Text";


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
        'label' => 'Update Text',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);


?>