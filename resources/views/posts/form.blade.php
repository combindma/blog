<div class="mt-8 grid grid-cols-1 gap-6 lg:grid-flow-col-dense lg:grid-cols-3">
    <div class="lg:col-start-1 lg:col-span-2">
        <!-- Titre/Contenu -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="mb-6">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" id="title" name="title" placeholder="Ajoutez un titre de l'article" value="{{ old('title', ucfirst(optional($post)->title)) }}" class="form-control" required>
                </div>
                <div class="mb-6">
                    <label for="editor" class="form-label">Contenu</label>
                    <textarea name="content" id="editor">{!! old('content', optional($post)->content) !!}</textarea>
                </div>
                <div class="mb-1">
                    <label for="markdown" class="form-label">Markdown</label>
                    <textarea name="markdown" id="markdown" class="form-control" rows="10">{!! old('markdown', optional($post)->markdown) !!}</textarea>
                </div>
            </div>
        </div>

        <!-- Extrait/Reading time -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="mb-6">
                    <label for="description" class="form-label">Extrait</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', optional($post)->description) }}</textarea>
                    <p class="mt-2 text-sm text-gray-600">Ajoutez un résumé de l'article qui s'affichera sur votre page d'accueil ou votre blog.</p>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="reading_time">Temps de lecture</label>
                    <input type="text" id="reading_time" name="reading_time" placeholder="5 min" value="{{ old('reading_time', optional($post)->reading_time) }}" class="form-control">
                </div>
            </div>
        </div>

        <!-- SEO -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend">Aperçu du référencement sur les moteurs de recherche</p>
                <p class="mt-2 mb-4 text-sm text-gray-600">Ajoutez un titre et une description pour voir comment votre Article de blog peut apparaître dans les résultats des moteurs de recherche.</p>
                <div class="mb-6">
                    <label class="form-label" for="meta_title">Titre de la page</label>
                    <input type="text" id="meta_title" name="meta_title" placeholder="Laissez vide, si vous voulez utiliser le titre de l'article" value="{{ old('meta_title', optional($post)->meta_title) }}" class="form-control">
                </div>
                <div class="mb-1">
                    <label class="form-label" for="meta_description">Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Laissez vide, si vous voulez utiliser l'extrait de l'article">{{ old('meta_description', optional($post)->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="lg:col-start-3 lg:col-span-1">
        <!-- Visibilité -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend mb-4">Visibilité</p>
                <div class="mb-6">
                    <label class="form-label" for="published_at">Date publication</label>
                    <input type="date" id="published_at" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}" class="form-control" required>
                </div>
                @if (!$createForm)
                    <div class="mb-6">
                        <label class="form-label" for="modified_at">Date modification</label>
                        <input type="date" id="modified_at" name="modified_at" value="{{ old('modified_at', optional($post->modified_at)->format('Y-m-d')) }}" class="form-control" required>
                    </div>
                @endif
                <div class="mb-6">
                    <label class="form-label" for="language">Langue</label>
                    <select class="form-control" name="language" id="language" required>
                        @foreach(\Combindma\Blog\Enums\Languages::asSelectArray() as $language=>$description)
                            <option value="{{ $language }}" @if($language === old('language', optional($post->language)->value)) selected @endif>{{ $description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="is_published" name="is_published" value="1" @if (old('is_published', optional($post)->is_published)) checked @endif>
                        <label for="is_published" class="ml-2 block text-sm text-gray-900">
                            Publier
                        </label>
                    </div>
                </div>

                <div class="mb-1">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="is_featured" name="is_featured" value="1"
                               @if (old('is_featured', optional($post)->is_featured)) checked @endif>
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Mettre en avant
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Vedette -->
        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend mb-4">Image vedette</p>
                <div class="p-4 border-4 border-dashed border-gray-200 rounded-lg">
                    <div class="mb-4">
                        @if (!$createForm && $post->featured_image())
                            {{ $post->featured_image() }}
                        @endif
                    </div>
                    <input type="file" class="form-control" name="post_image" accept="image/*">
                </div>
            </div>
        </div>


        <!-- Auteur/Catégories/tags -->
        <div class="mb-8 bg-gray-50 overflow-visible shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="form-legend mb-4">Organisation</p>
                <div class="mb-4">
                    <label class="form-label">Auteur</label>
                    <select class="form-control" name="author_id" required>
                        <option value="">Aucun auteur</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" @if($author->id === old('author_id', optional($post)->author_id)) selected="" @endif>{{ ucfirst($author->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="categories">Catégories</label>
                    <select class="js-select-multiple" name="categories[]" id="categories" required multiple>
                        <option value="">Selectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if (in_array($category->id, $post_categories, true)) selected @endif>
                                {{ ucfirst($category->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="tags">Tags</label>
                    <select class="form-control js-select-multiple" name="tags[]" id="tags" multiple>
                        <option value="">Choisissez un tag</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if (in_array($tag->id, $post_tags, true)) selected @endif>
                                {{ ucfirst($tag->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
