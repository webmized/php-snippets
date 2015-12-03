<?php

abstract Class FormObject
{

    /*
     * creado por: Franchesco Fonseca
     * Github user: frankirox
     * email: <franchesco@outlook.com>
     *
     * Este codigo es solo un ejemplo de libre uso, modifiquelo cuanto quiera y uselo para lo que quiera.
     *
     * Información IMPORTANTE sobre las [REGLAS]:
     * Los metodos que representen reglas de formulario deben ser espeficificados al momentos de añadir la regla
     * de la siguiete forma $form->addRule(['attribute' => 'attribute1', 'rule' => 'miregla'])
     * y tenga en cuenta que el codigo accede al medoto correspondiente a la regla anteponiendo el prefijo "rule",
     * de la siguiente manera dentro del metodo validate $this->ruleMiregla con solo la primera letra del nombre de la
     * regla en mayuscula.
     *
     * POR LO TANTO, si ud desea agregar una nueva regla siga el mismo patro para el nombre del método que
     * la representa: protected function ruleMiregla($attribute){...}  donde a través del parametro attribute
     * llegara el nombre del  atributo a validar.
     *
     * POR ULTIMO, si el metodo que usted cree para representar una regla, cumple la condicion de error, añada el
     * mensaje de error de la siguiente manera:
     *
     * $this->$_formErrors[$this->{$attribute}] = $this->attributeLabels($attribute)." "."debe cumplir con X condición";
     *
     * donde en esa linea de codigo simplemente estamos cargando el mensaje de error en un array donde deben estar los
     * errores, para luego mostrarlos al usuario en el formulario, el valor que se carga no es mas que el label definido
     * para el atributo concatenado a un string complementario que permita entender la natturaleza el error.
     *
     * Información IMPORTANTE sobre los [FILTROS]:
     *
     * Los filtros aplican la misma metodología antes descrita para las REGLAS, solo que no se manejan mensajes de
     * error, sustituye un valor dado de un atributo por el valor con el filtro ya aplicado.
     *
     * Es de notar que los filtros en el método validate() se ejecutan antes que la comprobación de las reglas.
     *
    */

    /*
    * las reglas a validar se almacenarán durante la línea de ejecución en este array vacío por defecto de la siguiente
    * manera:
    * [['attribute' => 'attribute1', 'rule' => 'required'], ['attribute' => 'attribute1', 'rule' => 'integer']]
    *
    */
    protected $_formRules = [];

    /*
    * los filtros a aplicar se almacenarán durante la línea de ejecución en este array vacío por defecto de la
    * siguiente manera:
    * [['attribute' => 'attribute1', 'filter' => 'uppercase'], ['attribute' => 'attribute1', 'filter' => 'trim']]
    *
    */

    protected $_formFilters = [];


    /*
    * los errores encontrados al validar las reglas se almacenarán en este array vacío de la siguiete manera para luego
    *  ser mostrados al usuario:
    *
    * ['attribute1' => ['mensaje del error 1', 'mensaje del error N...'],
    * 'attribute34' => ['mensaje del error 1', 'mensaje del error N...'],]
    *
    */

    protected $_formErrors = [];


    //metodo para registrar errores presentes en un campo del formulario
    protected function addError($attribute, $msg)
    {
        if (!isset($this->_formErrors[$this->{$attribute}])) {

            $this->_formErrors[$this->{$attribute}] = [];
        }

        $this->_formErrors[$this->{$attribute}][] = $msg;
    }

    public function attributeLabel($attribute)
    {

        // attribute => label
        $attributeLabels = [

        ];


        return ((isset($attributeLabels[$attribute]) ? $attributeLabels[$attribute] : null));
    }


    //devuelve un error si el tipo de dato no es entero
    protected function ruleInteger($attribute)
    {

        if (!is_int($this->{$attribute})) {

            $this->addError($attribute, $this->attributeLabels($attribute) . " " . "debe ser un número entero");
        }
    }

    //devuelve un error si el tipo de dato no es double
    protected function ruleDouble($value)
    {

        if (!is_double($this->{$attribute})) {

            $this->addError($attribute,
                $this->attributeLabels($attribute) . " " . "debe ser un número de doble precisión");
        }

    }

    //devuelve un error de datos faltantes si la validación no se cumple
    protected function ruleRequired($value)
    {

        if (empty($this->{$attribute})) {

            $this->addError($attribute, $this->attributeLabels($attribute) . " " . "es requerido");
        }
    }

    //asegura que lo que contenga el atributo no tenga espacio en blanco a los extremos
    protected function filterTrim($attribute)
    {
        $this->{$attribute} = strtoupper($this->{$attribute});
    }

    //asegura que lo que contenda el atributo se encuentre en mayuscula
    protected function filterUppercase($attribute)
    {
        $this->{$attribute} = strtoupper($this->{$attribute});
    }

    //asegura que lo que contenga el atributo se encuentre en minuscula
    protected function filterLowercase($attribute)
    {
        $this->{$attribute} = strtolower($this->{$attribute});
    }


    public function addRule($rule)
    {

        if (!is_array($rule)) {

            throw new Exception("Malformación de regla de formulario, una regla debe ser un array con la siguiente
             forma ['attribute' => attributeName, 'rule' => ruleName]");
        }

        if (!array_key_exists('attribute', $rule) || !array_key_exists('rule', $rule)) {

            throw new Exception("Malformación de regla de formulario, una regla representada en un array debe
             tener obligatoriamente la llave attribute y la llave rule");
        }

        if (count($rule) < 2 || count($rule) > 2) {

            throw new Exception("Malformación de regla de formulario, una regla puede tener solo
             2 posiciones en el array");
        }

        return $this->_formRules[] = $rule;
    }


    public function addFilter($filter)
    {

        if (!is_array($filter)) {

            throw new Exception("Malformación de filtro de formulario, un filtro debe ser un array con la siguiente
             forma ['attribute' => attributeName, 'filter' => filterName]");
        }

        if (!array_key_exists('attribute', $filter) || !array_key_exists('rule', $filter)) {

            throw new Exception("Malformación de filtro de formulario, un filtro representado en un array debe tener
             obligatoriamente la llave attribute y la llave filter");
        }

        if (count($filter) < 2 || count($filter) > 2) {

            throw new Exception("Malformación de filtro de formulario, un filtro puede tener solo 2
             posiciones en el array");
        }

        return $this->_defaultFilters[] = $filter;
    }


    public function load($array_attributes)
    {

        if (isset($array_attributes[get_class($this)])) {

            if (is_array($array_attributes[get_class($this)])) {

                foreach ($array_attributes[get_class($this)] as $attribute => $value) {

                    if (isset($this->{$attribute})) {

                        $this->{$attribute} = $value;
                    } else {

                        throw new Exception("el atributo {$attribute} no existe");
                    }
                }

                return true;
            }

        } else {

            throw new Exception("No fue recibido ningún dato");
        }

        return false;

    }

    public function validate()
    {

        //aplicar todos los filtros
        foreach ($this->_formFilters as $filterToApply) {

            $attributeToEval = $filterToApply['attribute'];

            if (!isset($this->{$attributeToEval})) {

                throw new Exception("El atributo {$attributeToEval} no existe");
            }

            $methoTobeUsed = "filter" . ucfirst($filterToApply['attribute']);

            if (!method_exists($this, $methoTobeUsed)) {

                throw new Exception("El método {$methoTobeUsed} no existe, no se puede filtrar
                 el atributo {$attributeToEval}");
            }

            $this->{$methoTobeUsed}($attributeToEval);

        }

        //validar todas las reglas
        foreach ($this->_formRules as $ruleToEval) {

            $attributeToEval = $ruleToEval['attribute'];

            if (!isset($this->{$attributeToEval})) {

                throw new Exception("El atributo {$attributeToEval} no existe");
            }

            $methoTobeUsed = "rule" . ucfirst($ruleToEval['attribute']);

            if (!method_exists($this, $methoTobeUsed)) {

                throw new Exception("El método {$methoTobeUsed} no existe, no se puede validar
                 el atributo {$attributeToEval}");
            }

            $this->{$methoTobeUsed}($attributeToEval);

        }

    }

}



