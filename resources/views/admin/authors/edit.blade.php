@extends('dashui::admin.layouts.app')
@section('title', 'Modifier Auteur')
@section('content')
    <div class="bg-white border-l border-gray-200">
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto space-y-8 divide-y divide-gray-200">
                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                                Modifier auteur
                            </h1>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-4">
                            <button onclick="document.getElementById('form-action').submit();" type="button" class="btn">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                    @include('admin.components.alert')
                </div>
                <form class="max-w-3xl mx-auto space-y-6 divide-y divide-gray-200" id="form-action" action="{{ route('blog::authors.update', $author) }}" method="POST" enctype="multipart/form-data">
                    @include('admin.posts.authors.form', ['createForm' => false])
                    @csrf
                    @method('PUT')
                    <div class="pt-5 flex justify-end">
                        <a href="{{ route('blog::authors.index') }}" class="btn-subtle">Retour</a>
                        <button type="submit" class="btn ml-3">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
