<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;

class ImageUrlEntry
{
    public function __construct(
        private readonly string $url,
        private readonly string $sha256,
        private readonly ?float $scale = null,
        private readonly ?int $size = null,
    ) {
        if (!str_starts_with($url, 'https://')) {
            throw new InvalidArgumentException('Upcoming pass information image URLs must use HTTPS.');
        }
    }

    /**
     * @return array<string, float|int|string>
     */
    public function toArray(): array
    {
        $data = [
            'URL' => $this->url,
            'SHA256' => $this->sha256,
        ];

        if ($this->scale !== null) {
            $data['scale'] = $this->scale;
        }

        if ($this->size !== null) {
            $data['size'] = $this->size;
        }

        return $data;
    }
}
