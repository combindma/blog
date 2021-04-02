<?php


namespace Combindma\Blog\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


Trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $filename = null, $disk = 'uploads', $folder = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25).'.'.$uploadedFile->getClientOriginalExtension();
        $file = $uploadedFile->storeAs($folder, $name, $disk);
        return Storage::disk($disk)->url($file);
    }
}
