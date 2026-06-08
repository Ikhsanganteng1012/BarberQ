<?php

namespace App\Traits;

trait HasPublicImage
{
    public function resolveImageUrl(?string $path = null): ?string
    {
        $path = $path ?? $this->image ?? null;

        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl();
    }
}
