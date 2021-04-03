<?php

namespace Combindma\Blog\Http\Controllers;


use Combindma\Blog\Http\Requests\PostRequest;
use Combindma\Blog\ModelFilters\PostFilter;
use Combindma\Blog\Models\Author;
use Combindma\Blog\Models\Post;
use Combindma\Blog\Models\PostCategory;
use Combindma\Blog\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
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

        flash(__('blog::messages.created'));
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

        flash(__('blog::messages.updated'));
        return back();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        flash(__('blog::messages.deleted'));
        return back();
    }

    public function restore($id)
    {
        Post::withTrashed()->where('id',$id)->restore();
        flash(__('blog::messages.restored'));
        return back();
    }

    public function uploadOne(UploadedFile $uploadedFile, $filename = null, $disk = 'uploads', $folder = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25).'.'.$uploadedFile->getClientOriginalExtension();
        $file = $uploadedFile->storeAs($folder, $name, $disk);
        return Storage::disk($disk)->url($file);
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
