<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;
use MASFB\Web\Value\Content\Data\AktualitaData;
use MASFB\Web\Value\Content\Data\TagData;

#[AsTwigComponent]
readonly final class Aktuality
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @param array<TagData> $kategorie
     * @return array<AktualitaData>
     */
    public function getItems(int $Pocet, array $kategorie): array
    {
        $tagSlugs = [];
        foreach ($kategorie as $kategorieItem) {
            $tagSlugs[] = $kategorieItem->slug;
        }

        return $this->content->getAktualityData(limit: $Pocet, tag: $tagSlugs);
    }
}
