<?php

include 'BaseFormObject.php';
/**
 * Created by PhpStorm.
 * User: Franchesco
 * Date: 03/12/2015
 * Time: 12:45 AM
 */
class ExampleForm extends  BaseFormObject
{

    public $field1;
    public $field2;
    public $field3;
    public $field4;
    public $field5;

    protected $_attributeLabels = [
        'field1' => 'Campo 1',
        'field2' => 'Campo 2',
        'field3' => 'Campo 3',
        'field4' => 'Campo 4',
        'field5' => 'Campo 5',
    ];

    public function rules(){

        $this->addRule(['attribute' => 'field1', 'rule' =>'integer']);
        $this->addRule(['attribute' => 'field4', 'rule' =>'numeric']);
        $this->addRule(['attribute' => 'field5', 'rule' =>'required']);
    }

    public function filters(){

        $this->addFilter(['attribute' => 'field5', 'filter' =>'uppercase']);
        $this->addFilter(['attribute' => 'field3', 'filter' =>'trim']);
    }




}