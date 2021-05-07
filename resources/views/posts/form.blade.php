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
                    <label for="markdown" class="form-label">Contenu - Markdown</label>
                    <div class="flex items-center mb-2">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" viewBox="0 0 24 24" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                            <path d="M23.997,6.002c0,-3.311 -2.688,-5.999 -5.999,-5.999l-11.999,0c-3.311,0 -5.999,2.688 -5.999,5.999l0,11.999c0,3.311 2.688,5.999 5.999,5.999l11.999,0c3.311,0 5.999,-2.688 5.999,-5.999l0,-11.999Z" style="fill:none;"/><clipPath id="_clip1"><path d="M23.997,6.002c0,-3.311 -2.688,-5.999 -5.999,-5.999l-11.999,0c-3.311,0 -5.999,2.688 -5.999,5.999l0,11.999c0,3.311 2.688,5.999 5.999,5.999l11.999,0c3.311,0 5.999,-2.688 5.999,-5.999l0,-11.999Z"/></clipPath><g clip-path="url(#_clip1)"><path d="M23.997,0.003l-24,0l12,12l12,-12Z" style="fill:#ffd700;"/><path d="M-0.003,0.003l0,24l12,-12l-12,-12Z" style="fill:#a5c700;"/><path d="M-0.003,24.003l24,0l-12,-12l-12,12Z" style="fill:#ff8a00;"/><path d="M23.997,24.003l0,-24l-12,12l12,12Z" style="fill:#66aefd;"/><path d="M22.497,-1.497l-10.5,10.497l3,3.003l10.5,-10.5l-3,-3Z" style="fill:url(#_Linear2);"/><path d="M25.499,22.503l-10.498,-10.5l-3.002,3l10.5,10.5l3,-3Z" style="fill:url(#_Linear3);"/><path d="M1.497,25.501l10.5,-10.497l-3,-3.003l-10.5,10.5l3,3Z" style="fill:url(#_Linear4);"/><path d="M-1.503,1.503l10.498,10.5l3.002,-3l-10.5,-10.5l-3,3Z" style="fill:url(#_Linear5);"/></g><path d="M21.75,5.852c0,-2.195 -1.782,-3.977 -3.977,-3.977l-11.546,0c-2.195,0 -3.977,1.782 -3.977,3.977l0,11.546c0,2.195 1.782,3.977 3.977,3.977l11.546,0c2.195,0 3.977,-1.782 3.977,-3.977l0,-11.546Z" style="fill:#fff;"/><path d="M4.633,6.013l1.37,0l0,-1.828l1.399,0l0,1.828l1.696,0l0,-1.828l1.399,0l0,1.828l1.37,0l0,1.691l-1.37,0l0,1.902l1.37,0l0,1.69l-1.37,0l0,1.829l-1.399,0l0,-1.829l-1.696,0l0,1.829l-1.399,0l0,-1.829l-1.37,0l0,-1.69l1.37,0l0,-1.902l-1.37,0l0,-1.691Zm2.769,1.691l0,1.902l1.696,0l0,-1.902l-1.696,0Z" style="fill:#737373;"/><defs><linearGradient id="_Linear2" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(-2.99995,-3,3,-2.99995,23.9974,3.00265)"><stop offset="0" style="stop-color:#66aefd;stop-opacity:1"/><stop offset="1" style="stop-color:#ffd700;stop-opacity:1"/></linearGradient><linearGradient id="_Linear3" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(3,-2.99995,2.99995,3,20.9987,24.0027)"><stop offset="0" style="stop-color:#ff8a00;stop-opacity:1"/><stop offset="1" style="stop-color:#66aefd;stop-opacity:1"/></linearGradient><linearGradient id="_Linear4" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(2.99995,3,-3,2.99995,-0.00255928,21.0013)"><stop offset="0" style="stop-color:#a5c700;stop-opacity:1"/><stop offset="1" style="stop-color:#ff8a00;stop-opacity:1"/></linearGradient><linearGradient id="_Linear5" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(-3,2.99995,-2.99995,-3,2.99744,0.00265252)"><stop offset="0" style="stop-color:#ffd700;stop-opacity:1"/><stop offset="1" style="stop-color:#a5c700;stop-opacity:1"/></linearGradient></defs>
                        </svg>
                        <button type="button" onclick="openEditor()" class="ml-1 relative inline-flex items-center text-sm font-medium underline text-primary-700">
                            Modifier contenu avec StackEdit
                        </button>
                    </div>
                    <textarea name="markdown" id="markdown" class="form-control" rows="8">{!! old('markdown', optional($post)->markdown) !!}</textarea>
                </div>
                <div x-data="{ isExpanded:false }">
                    <div class="mt-4" x-show="!isExpanded">
                        <button @click="isExpanded = true" type="button" class="relative inline-flex items-center text-sm font-medium underline text-primary-700">
                            Modifier contenu avec l'editeur
                        </button>
                    </div>
                    <div class="mb-6" x-show="isExpanded">
                        <label for="editor" class="form-label">Contenu</label>
                        <textarea name="content" id="editor">{!! old('content', optional($post)->content) !!}</textarea>
                    </div>
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
                <div class="mt-3">
                    @if (!$createForm && $post->featured_image())
                        {{ $post->featured_image() }}
                    @endif
                </div>
                <div class="mt-3 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <input id="image" name="image" type="file" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG jusqu'à 1MB
                        </p>
                    </div>
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
