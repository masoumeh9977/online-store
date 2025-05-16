<?php

namespace App;

trait HasMediaTrait
{
    public function setMedia($media, string $collection = 'default', bool $clearExisting = true): void
    {
        if ($clearExisting) {
            $this->clearMediaCollection($collection);
        }

        if (is_array($media)) {
            foreach ($media as $file) {
                $this->addMedia($file)->toMediaCollection($collection);
            }
        } else {
            $this->addMedia($media)->toMediaCollection($collection);
        }
    }

    public function getMediaUrls(string $collection = 'default')
    {
        return $this->getMedia($collection)->map(function ($media) {
            return $media->getUrl();
        });
    }

    public function getFirstMediaUrlSafe(string $collection = 'default'): ?string
    {
        return $this->getFirstMediaUrl($collection) ?: null;
    }
}
