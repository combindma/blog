<div class="space-y-8 divide-y divide-gray-200">
    <div class="mb-8">
        <div class="@if(!$createForm) mt-4 @endif">
            <h3 class="form-legend">
                Photo de profil
            </h3>
        </div>
        <div class="mt-6">
            <div class="flex items-center">
                @if (!$createForm && $author->avatar())
                    <img src="{{ $author->avatar() }}" class="h-12 w-12 rounded-full overflow-hidden object-cover">
                @else
                    <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </span>
                @endif
                <input type="file" name="avatar" accept="image/*" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            </div>
        </div>
    </div>
</div>

<div class="pt-8">
    <div class="mb-6">
        <h3 class="form-legend">
            Informations personnelles
        </h3>
    </div>
    <div class="mb-4">
        <label class="form-label">Nom complet</label>
        <input type="text" name="name" value="{{ old('name', optional($author)->name) }}" class="form-control" required>
    </div>
    @if (!$createForm)
        <div class="mb-4">
            <label class="form-label">Identifiant (slug)</label>
            <input type="text" name="slug" value="{{ old('slug', optional($author)->slug) }}" class="form-control" required>
        </div>
    @endif

    <div class="mb-4">
        <label class="form-label">Intitulé poste</label>
        <input type="text" name="job" value="{{ old('job', optional($author)->job) }}" class="form-control" required>
    </div>
    <div class="mb-4">
        <label class="form-label" for="description">Description</label>
        <textarea name="description" class="form-control" rows="4" id="description">{{ old('description', optional($author)->description) }}</textarea>
    </div>
</div>
<div class="pt-8">
    <div class="mb-6">
        <h3 class="form-legend">
            Réseaux sociaux
        </h3>
    </div>

    <div class="mb-4">
        <label class="form-label">Facebook</label>
        <input type="text" name="meta[facebook]" value="{{ old("meta.facebook", optional($author->meta)['facebook']) }}" class="form-control">
    </div>
    <div class="mb-4">
        <label class="form-label">Instagram</label>
        <input type="text" name="meta[instagram]" value="{{ old("meta.instagram", optional($author->meta)['instagram']) }}" class="form-control">
    </div>
    <div class="mb-4">
        <label class="form-label">LinkedIn</label>
        <input type="text" name="meta[linkedin]" value="{{ old("meta.linkedin", optional($author->meta)['linkedin']) }}" class="form-control">
    </div>
    <div class="mb-4">
        <label class="form-label">Twitter</label>
        <input type="text" name="meta[twitter]" value="{{ old("meta.twitter", optional($author->meta)['twitter']) }}" class="form-control">
    </div>
</div>
