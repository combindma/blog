<?php

namespace Combindma\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withTrashed()->oldest('order_column')->get();
        return view('admin.posts.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        flash('Ajout effectué avec succès');
        return redirect(route('admin::tags.index'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.posts.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        flash('Enregistrement effectué avec succès');
        return back();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        flash('Ettiquette supprimée avec succès');
        return back();
    }

    public function restore($id)
    {
        Tag::withTrashed()->where('id',$id)->restore();
        flash('Etiquette restaurée avec succès');
        return back();
    }
}
