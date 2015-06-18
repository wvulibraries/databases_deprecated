<?php

$form = formBuilder::createForm('accessTypes');
$form->linkToDatabase(array(
    'table'       => 'accessTypes'
));

$form->insertTitle = "New Access Types";
$form->editTitle   = "Edit Access Types";


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
        'label' => 'Access Type',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);


?>