<?php

namespace Entercode\Helper\Laravel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    protected $disk;
    public function __construct($disk = null)
    {
        $this->disk = $disk ?? config('filesystems.default');
    }
    public function upload(string $folder, $file, string $filename = null)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $filename ?? Str::uuid() . '-' . time() . '.' . $extension;
        return $file->storeAs($folder, $filename, ['disk' => $this->disk]);
    }

    public function delete(string $path)
    {
        $path = str_replace(Storage::disk($this->disk)->url('/'), '', $path);
        if (Storage::exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }
    }
}
