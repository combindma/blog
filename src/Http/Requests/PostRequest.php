<?php

namespace Combindma\Blog\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Combindma\Blog\Enums\Languages;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'trim|lowercase',
            'description' => 'trim|lowercase',
            'meta_title' => 'trim|escape',
            'meta_description' => 'trim|escape',
            'reading_time' => 'trim|escape|lowercase',
        ];
    }

    public function createRules()
    {
        return [
            'categories.*' => 'nullable|numeric',
            'author_id' => 'nullable|numeric',
            'tags.*' => 'nullable|numeric',
            'title' => 'required|string',
            'language' => ['required', new EnumValue(Languages::class, false)],
            'content' => 'required|string',
            'description' => 'required|string',
            'reading_time' => 'nullable|string',
            'published_at' => 'required|date_format:Y-m-d',
            'is_published' => 'present|boolean',
            'is_featured' => 'present|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'post_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
        ];
    }

    public function updateRules()
    {
        return [
            'categories.*' => 'nullable|numeric',
            'author_id' => 'nullable|numeric',
            'tags.*' => 'nullable|numeric',
            'title' => 'required|string',
            'language' => ['required', new EnumValue(Languages::class, false)],
            'content' => 'required|string',
            'description' => 'required|string',
            'reading_time' => 'nullable|string',
            'published_at' => 'required|date_format:Y-m-d',
            'modified_at' => 'required|date_format:Y-m-d',
            'is_published' => 'present|boolean',
            'is_featured' => 'present|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'post_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'dimensions:max_width=2500,max_height=2500', 'max:1024'],
        ];
    }

    public function attributes()
    {
        return [
            'categories.*' => 'catégories',
            'author_id' => 'auteur',
            'tags.*' => 'tags',
            'title' => 'titre',
            'language' => 'language',
            'content' => 'contenu',
            'reading_time' => 'temps de lecture',
            'published_at' => 'date publication',
            'modified_at' => 'date modification',
            'meta_title' => 'meta titre',
            'meta_description' => 'meta description',
            'post_image' => 'image mise en avant',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_published' => $this->is_published ?? 0,
            'is_featured' => $this->is_featured ?? 0,
        ]);
    }
}
