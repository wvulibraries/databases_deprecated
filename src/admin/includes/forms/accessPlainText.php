<?php

$form = formBuilder::createForm('accessPlainText');
$form->linkToDatabase(array(
    'table'       => 'accessPlainText'
));

$form->insertTitle = "New Access Plain Text";
$form->editTitle   = "Edit Access Plain Text";


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
        'label' => 'Access Plain Text',
        'required'   => TRUE,
        'duplicates' => FALSE
    )
);

$form->addField(
    array(
        'name'  => "assignedTo",
        'label' => "Assigned to",
        'type' => "plaintext",
        'value' => '<a href="list/?id={ID}">Assigned to</a>',
        'showIn' => array(formBuilder::TYPE_EDIT),
        )
);

?>