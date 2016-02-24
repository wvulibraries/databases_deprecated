<?php

$form = formBuilder::createForm('Subjects');
$form->linkToDatabase(array(
    'table'       => 'subjects',
    'order'       => 'name'
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
        'type'  => 'url'
    )
);

$form->addField(
    array(
        'name'  => "orderCuratedDatabases",
        'label' => "Order Curated DBs",
        'type'  => "plainText",
        'value' => sprintf('<a href="order/?id={ID}">Edit</a>')

        )
    );

?>