<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function storage(Request $request)
    {
        $path = $request->query('path', '');

        $path = trim(str_replace(['..', './', '\\'], '', $path), '/');

        $disk = Storage::disk('local');

        if ($path === '') {
            $fullPath = storage_path('app');
            $directories = $disk->directories('');
            $files = $disk->files('');
            $currentPath = '';
        } else {
            $fullPath = storage_path('app/' . $path);

            if (!file_exists($fullPath)) {
                abort(404, 'Папка не найдена.');
            }

            if (!is_dir($fullPath)) {
                abort(404, 'Путь не является папкой.');
            }

            $directories = $disk->directories($path);
            $files = $disk->files($path);
            $currentPath = $path;
        }

        return view('storage', [
            'currentPath' => $currentPath,
            'directories' => $directories,
            'files' => $files,
        ]);
    }
}
