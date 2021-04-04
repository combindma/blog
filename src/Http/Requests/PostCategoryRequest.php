<?php

namespace Combindma\Blog\Http\Requests;

use Combindma\Blog\Rules\Slug;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCategoryRequest extends FormRequest
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
        if ($this->getMethod() === 'PATCH') {
            return $this->updateRules();
        }

        return $this->createRules();
    }

    public function filters()
    {
        return [
            'name' => 'trim|lowercase',
            'slug' => 'trim|lowercase',
            'description' => 'trim|lowercase',
        ];
    }

    public function createRules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'visible_in_menu' => 'nullable|boolean',
            'browsable' => 'nullable|boolean',
        ];
    }

    public function updateRules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'slug' => ['required', Rule::unique('post_categories')->ignore($this->post_category), new Slug()],
            'visible_in_menu' => 'nullable|boolean',
            'browsable' => 'nullable|boolean',
            'order_column' => 'nullable|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'visible_in_menu' => $this->visible_in_menu ?? 0,
            'browsable' => $this->browsable ?? 0,
        ]);
    }
}
