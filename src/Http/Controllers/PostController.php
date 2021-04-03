<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\PostRequest;
use Combindma\Blog\ModelFilters\PostFilter;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Models\Tag;
use Combindma\Blog\Traits\UploadTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use UploadTrait;

    public function index(Request $request)
    {
        $posts = Post::filter($request->all(), PostFilter::class)
            ->with(['media', 'author', 'categories'])
            ->latest('id')
            ->paginate(10);
        return view('blog::admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();
        $categories  = PostCategory::get(['id', 'name']);
        $authors  = Author::get(['id', 'name']);
        $tags = Tag::get(['id', 'name']);
        $post_tags= array();
        $post_categories = array();
        return view('blog::admin.posts.create', compact('post', 'categories', 'authors', 'tags', 'post_tags', 'post_categories'));
    }

    public function store(PostRequest $request)
    {
        $post = Post::create(array_merge($request->validated(), ['modified_at' => $request->published_at]));

        if($request->filled('tags')){
            $post->tags()->attach($request->tags);
        }

        if($request->filled('categories')){
            $post->categories()->attach($request->categories);
        }

        if ($request->hasFile('post_image'))
        {
            // Add Media
            $post->addImage($request->file('post_image'));
        }

        flash(__('Ajout effectué avec succès'));
        return redirect(route('blog::posts.edit', $post));
    }

    public function edit(Post $post)
    {
        $categories  = PostCategory::get(['id', 'name']);
        $authors  = Author::get(['id', 'name']);
        $tags = Tag::get(['id', 'name']);
        $post_tags= $post->tagsIds();
        $post_categories = $post->categoriesIds();
        return view('blog::admin.posts.edit', compact('post', 'categories', 'authors', 'tags', 'post_tags', 'post_categories'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);

        if ($request->hasFile('post_image'))
        {
            // Update Media
            $post->addImage($request->file('post_image'));
        }

        flash(__('Enregistrement effectué avec succès'));
        return back();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        flash(__('Article supprimé avec succès'));
        return back();
    }

    public function restore($id)
    {
        Post::withTrashed()->where('id',$id)->restore();
        flash(__('Article restauré avec succès'));
        return back();
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload'))
        {
            // Upload image
            $image = $this->uploadOne($request->file('upload'));
            // Add Media
            if (!empty($image))
            {
                return response()->json([
                    'uploaded'=> true,
                    'url' => $image
                ]);
            }

        }

        return response()->json([
            'uploaded'=> false,
            'error' => [
                'message' => __('impossible de télécharger cette image, veuillez réessayer')
            ]
        ]);
    }
}
