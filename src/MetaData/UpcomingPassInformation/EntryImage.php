<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation;

class EntryImage
{
    /** @var ImageUrlEntry[] */
    private array $urls = [];
    private bool $reuseExisting = false;

    public function addUrl(ImageUrlEntry $url): void
    {
        $this->urls[] = $url;
    }

    public function reuseExisting(): void
    {
        $this->reuseExisting = true;
    }

    /**
     * @return array<string, bool|array<int, array<string, float|int|string>>>
     */
    public function toArray(): array
    {
        $data = [];

        foreach ($this->urls as $url) {
            $data['URLs'][] = $url->toArray();
        }

        if ($this->reuseExisting) {
            $data['reuseExisting'] = true;
        }

        return $data;
    }
}
