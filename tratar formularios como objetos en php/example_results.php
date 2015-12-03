<?php

include 'ExampleForm.php';

if(!isset($_POST)){

    throw new Exception("No fue recibido ningún POST");

}else{

    header('Content-Type: text/html; charset=utf-8');
    $formObject = new ExampleForm();
    $formObject->load($_POST);

    echo "Validar formulario <br>";
    var_dump($formObject->validate());

    echo "Errores encontrados <br>";
    var_dump($formObject->getErrors());


    echo "Field1: {$formObject->field1} <br>";
    echo "Field2: {$formObject->field2} <br>";
    echo "Field3: {$formObject->field3} <br>";
    echo "Field4: {$formObject->field4} <br>";
    echo "Field5: {$formObject->field5} <br>";

}