<?php

namespace Combindma\Blog\Http\Requests;

use Combindma\Blog\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class TagRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->getMethod() === 'PUT') {
            return $this->updateRules();
        }
        if ($this->getMethod() === 'PATCH'){
            return $this->updateRules();
        }
        return $this->createRules();
    }

    public function filters()
    {
        return [
            'name' => 'trim|lowercase',
            'slug' => 'trim|lowercase',
        ];
    }

    public function createRules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function updateRules()
    {
        return [
            'name' => 'required|string',
            'slug' => ['required', Rule::unique('tags')->ignore($this->tag), new Slug()],
            'order_column' => 'nullable|numeric'
        ];
    }
}
