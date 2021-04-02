<?php

namespace Combindma\Blog\Rules;

use Illuminate\Contracts\Validation\Rule;

class Slug implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
    }

    public function message()
    {
        return 'Le champs :attribute ne doit pas comporter d\'espace ou des caratères spéciaux.';
    }
}
