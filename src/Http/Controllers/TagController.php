<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\TagRequest;
use Combindma\Blog\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withTrashed()->oldest('order_column')->get();
        return view('blog::posts.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        flash(__('Ajout effectué avec succès'));
        return redirect(route('blog::tags.index'));
    }

    public function edit(Tag $tag)
    {
        return view('blog::posts.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        flash(__('Enregistrement effectué avec succès'));
        return back();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        flash(__('Ettiquette supprimée avec succès'));
        return back();
    }

    public function restore($id)
    {
        Tag::withTrashed()->where('id',$id)->restore();
        flash(__('Etiquette restaurée avec succès'));
        return back();
    }
}
