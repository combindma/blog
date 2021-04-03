<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\TagRequest;
use Combindma\Blog\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withTrashed()->oldest('order_column')->get();
        return view('blog::admin.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        flash(__('blog::messages.created'));
        return redirect(route('blog::tags.index'));
    }

    public function edit(Tag $tag)
    {
        return view('blog::admin.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        flash(__('blog::messages.updated'));
        return back();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        flash(__('blog::messages.deleted'));
        return back();
    }

    public function restore($id)
    {
        Tag::withTrashed()->where('id',$id)->restore();
        flash(__('blog::messages.restored'));
        return back();
    }
}
