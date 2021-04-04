@extends('dashui::layouts.app')
@section('title', 'Modifier tag')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="shadow sm:rounded-md">
            <form action="{{ route('blog::tags.update', $tag) }}" method="POST">
                <div class="bg-white py-6 px-4 sm:p-6">
                    <div class="mb-4">
                        <h1 class="text-lg leading-6 font-medium text-gray-900">Modifier nom tag</h1>
                    </div>
                    @include('dashui::components.alert')
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Identifiant (Slug)</label>
                        <input type="text" name="slug" value="{{ old('slug', $tag->slug) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Position</label>
                        <input type="number" name="order_column" value="{{ old('order_column', optional($tag)->order_column) }}" class="form-control" required>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a class="btn-subtle" href="{{ route('blog::tags.index') }}">Retour</a>
                    <button type="submit" class="ml-2 btn">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
