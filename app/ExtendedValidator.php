<?php 

namespace App;

use Illuminate\Validation\Validator;

class ExtendedValidator extends Validator {

    public function validateEach($attribute, $value, $parameters)
    {
        // Transform the each rule
        // For example, `each:exists,users,name` becomes `exists:users,name`
        $ruleName = array_shift($parameters);
        $rule = $ruleName.(count($parameters) > 0 ? ':'.implode(',', $parameters) : '');

        foreach ($value as $arrayKey => $arrayValue)
        {
            $this->validate($attribute.'.'.$arrayKey, $rule);
        }

        // Always return true, since the errors occur for individual elements.
        return true;
    }

    protected function getAttribute($attribute)
    {
        // Get the second to last segment in singular form for arrays.
        // For example, `group.names.0` becomes `name`.
        if (str_contains($attribute, '.'))
        {
            $segments = explode('.', $attribute);

            $attribute = str_singular($segments[count($segments) - 2]);
        }

        return parent::getAttribute($attribute);
    }
}