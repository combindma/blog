@extends('dashui::layouts.app')
@section('title', 'Modifier Catégorie')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="shadow sm:rounded-md">
            <form action="{{ route('blog::post_categories.update', $post_category) }}" method="POST">
                <div class="bg-white py-6 px-4 sm:p-6">
                    <div class="mb-4">
                        <h1 class="text-lg leading-6 font-medium text-gray-900">Modifier nom catégorie</h1>
                    </div>
                    @include('dashui::components.alert')
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" value="{{ old('name', $post_category->name) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Identifiant (slug)</label>
                        <input type="text" name="slug" value="{{ old('slug', $post_category->slug) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', optional($post_category)->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Position</label>
                        <input type="number" name="order_column" value="{{ old('order_column', optional($post_category)->order_column) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <div class="flex items-center">
                            <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="visible_in_menu" name="visible_in_menu" value="1"
                                   @if (old('visible_in_menu', optional($post_category)->visible_in_menu)) checked @endif>
                            <label for="visible_in_menu" class="ml-2 block text-sm text-gray-900">
                                Afficher dans le menu/footer
                            </label>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="flex items-center">
                            <input class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" type="checkbox" id="browsable" name="browsable" value="1"
                                   @if (old('browsable', optional($post_category)->browsable)) checked @endif>
                            <label for="browsable" class="ml-2 block text-sm text-gray-900">
                                Lister sur le mneu blog
                            </label>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a class="btn-subtle" href="{{ route('blog::post_categories.index') }}">Retour</a>
                    <button type="submit" class="ml-2 btn">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
