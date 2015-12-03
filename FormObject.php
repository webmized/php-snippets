
<?php

abstract Class FormObject(){


	protected $_defaultRules = [
		'integer',
		'double',
		'required',
		'trim',
		'uppercase',
		'lowercase',
	];

	protected $_formRules = [];

	protected $_formErrors = [];


	//devuelve un error si el tipo de dato no es entero
	protected function _integerRule($value)
	{

	}

	//devuelve un error si el tipo de dato no es double
	protected function _doubleRule($value)
	{

	}

	//devuelve un error de datos faltantes si la validación no se cumple
	protected function _requiredRule($value)
	{

	}

	//elimina los espacios en blanco
	protected function _trimFilter($value)
	{

	}

	//convi
	protected function _uppercaseFilter($value)
	{

	}

	protected function lowercaseFilter()
	{

	}


	public function addFormRule($rule)
	{

		if(!is_array($rule)){

			throw new Exception("Malformación de regla de formulario, una regla debe ser un array con la siguiente forma ['attribute' => attributeName, 'rule' => ruleName]");	
		}

		if(!array_key_exists('attribute', $rule) || !array_key_exists('rule', $rule)){

			throw new Exception("Malformación de regla de formulario, una regla representada en un array debe tener obligatoriamente la llave attribute y la llave rule");
		}

		if(count($rule) < 2 || count($rule) > 2){
			
			throw new Exception("Malformación de regla de formulario, una regla puede tener solo 2 posiciones en el array");
		}

		return $this->$_defaultRules[] = $rule;
	}


	public function load($array_attributes)
	{

		if(isset($array_attributes[get_class($this)])){

			if(is_array($array_attributes[get_class($this)])){

				foreach($array_attributes[get_class($this)] as $attribute => $value){

					if(($this->{$attribute})){

						$this->{$attribute} = $value;
					}
				}

				return true;
			}

		}

		return false;
		
	}


	public function validate()
	{


	}


	public function save()
	{
				$queryFields = [];
		$queryValues = [];

		foreach($_POST['AndresosoForm'] as $key => $value){

			$queryFields[] = $key;
			$queryValues[] = "'".$value."'";
		}

	}

}



