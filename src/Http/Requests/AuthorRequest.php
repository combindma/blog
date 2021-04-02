<?php

namespace Combindma\Blog\Http\Requests;

use Combindma\Blog\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Elegant\Sanitizer\Laravel\SanitizesInput;

class AuthorRequest extends FormRequest
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
            'job' => 'nullable|string',
            'description' => 'nullable|string',
            'meta.*' => 'nullable|string',
            'avatar' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
        ];
    }

    public function updateRules()
    {
        return [
            'name' => 'required|string',
            'slug' => ['required', Rule::unique('authors')->ignore($this->author), new Slug()],
            'job' => 'nullable|string',
            'description' => 'nullable|string',
            'meta.*' => 'nullable|string',
            'avatar' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
            'order_column' => 'nullable|numeric'
        ];
    }
}
