<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\PostCategoryRequest;
use Combindma\Blog\Models\PostCategory;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withTrashed()->oldest('order_column')->get();
        return view('blog::posts.categories.index', compact('categories'));
    }

    public function store(PostCategoryRequest $request)
    {
        PostCategory::create($request->validated());

        flash(__('Ajout effectué avec succès'));
        return redirect(route('blog::post_categories.index'));
    }


    public function edit(PostCategory $post_category)
    {
        return view('blog::posts.categories.edit', compact('post_category'));
    }

    public function update(PostCategoryRequest $request, PostCategory $post_category)
    {
        $post_category->update($request->validated());

        flash(__('Enregistrement effectué avec succès'));
        return back();
    }

    public function destroy(PostCategory $post_category)
    {
        $post_category->delete();

        flash(__('Catégorie supprimée avec succès'));
        return back();
    }

    public function restore($id)
    {
        PostCategory::withTrashed()->where('id',$id)->restore();
        flash(__('Catégorie restaurée avec succès'));
        return back();
    }
}
