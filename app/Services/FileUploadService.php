<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    private const DEFAULT_DISK = 'public';

    public function store(
        UploadedFile $file,
        string $directory,
        string $disk = self::DEFAULT_DISK,
        ?string $filename = null
    ): string {
        $directory = $this->normalizePath($directory);
        $resolvedFilename = $filename ?: $this->resolveOriginalFilename($file, $directory, $disk);

        return $file->storeAs($directory, $resolvedFilename, $disk);
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     */
    public function storeMany(array $files, string $directory, string $disk = self::DEFAULT_DISK): array
    {
        $paths = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $paths[] = $this->store($file, $directory, $disk);
        }

        return $paths;
    }

    public function delete(string $path, string $disk = self::DEFAULT_DISK): bool
    {
        $path = $this->normalizePath($path);

        if ($path === '' || ! $this->disk($disk)->exists($path)) {
            return false;
        }

        return $this->disk($disk)->delete($path);
    }

    public function exists(string $path, string $disk = self::DEFAULT_DISK): bool
    {
        $path = $this->normalizePath($path);

        if ($path === '') {
            return false;
        }

        return $this->disk($disk)->exists($path);
    }

    public function url(string $path, string $disk = self::DEFAULT_DISK): string
    {
        $path = $this->normalizePath($path);
        $baseUrl = config("filesystems.disks.{$disk}.url");

        if (is_string($baseUrl) && $baseUrl !== '') {
            return rtrim($baseUrl, '/').'/'.$path;
        }

        return '/storage/'.$path;
    }

    public function move(string $from, string $to, string $disk = self::DEFAULT_DISK): bool
    {
        $from = $this->normalizePath($from);
        $to = $this->normalizePath($to);

        if ($from === '' || $to === '' || ! $this->disk($disk)->exists($from)) {
            return false;
        }

        return $this->disk($disk)->move($from, $to);
    }

    private function resolveOriginalFilename(UploadedFile $file, string $directory, string $disk): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $baseName = Str::slug($originalName ?: 'file', '-');
        $baseName = $baseName !== '' ? $baseName : 'file';
        $candidate = $baseName.($extension ? '.'.$extension : '');
        $counter = 1;

        while ($this->disk($disk)->exists($directory.'/'.$candidate)) {
            $candidate = $baseName.'-'.$counter.($extension ? '.'.$extension : '');
            $counter++;
        }

        return $candidate;
    }

    private function normalizePath(string $path): string
    {
        return trim($path, '/');
    }

    private function disk(string $disk)
    {
        return Storage::disk($disk);
    }
}
