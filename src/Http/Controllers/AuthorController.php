<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\AuthorRequest;
use Combindma\Blog\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withTrashed()->with(['media'])->get();
        return view('blog::admin.posts.authors.index', compact('authors'));
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());

        if ($request->hasFile('avatar'))
        {
            // Add Media
            $author->addImage($request->file('avatar'));
        }

        flash(__('Ajout effectué avec succès'));
        return redirect(route('blog::authors.index'));
    }


    public function edit(Author $author)
    {
        return view('blog::admin.posts.authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        if ($request->hasFile('avatar'))
        {
            // Update Media
            $author->addImage($request->file('avatar'));
        }

        flash(__('Enregistrement effectué avec succès'));
        return back();
    }

    public function destroy(Author $author)
    {
        $author->delete();
        flash(__('Auteur supprimé avec succès'));
        return back();
    }

    public function restore($id)
    {
        Author::withTrashed()->where('id',$id)->restore();
        flash(__('Auteur restauré avec succès'));
        return back();
    }
}
