<?php

$form = formBuilder::createForm('Subjects');
$form->linkToDatabase(array(
    'table'       => 'subjects'
));

$form->insertTitle = "New Subject";
$form->editTitle   = "Edit Subjcets";


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
        'label' => 'Subject',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

$form->addField(
    array(
        'name'  => 'url',
        'label' => 'Subject URL',
        'type'  => 'url',
        'duplicates' => FALSE
    )
);

?>