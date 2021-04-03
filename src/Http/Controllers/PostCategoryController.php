<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\PostCategoryRequest;
use Combindma\Blog\Models\PostCategory;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withTrashed()->oldest('order_column')->get();
        return view('blog::admin.categories.index', compact('categories'));
    }

    public function store(PostCategoryRequest $request)
    {
        PostCategory::create($request->validated());
        flash(__('blog::messages.created'));
        return redirect(route('blog::post_categories.index'));
    }


    public function edit(PostCategory $post_category)
    {
        return view('blog::admin.categories.edit', compact('post_category'));
    }

    public function update(PostCategoryRequest $request, PostCategory $post_category)
    {
        $post_category->update($request->validated());
        flash(__('blog::messages.updated'));
        return back();
    }

    public function destroy(PostCategory $post_category)
    {
        $post_category->delete();
        flash(__('blog::messages.deleted'));
        return back();
    }

    public function restore($id)
    {
        PostCategory::withTrashed()->where('id',$id)->restore();
        flash(__('blog::messages.restored'));
        return back();
    }
}
