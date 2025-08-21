<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\KalendarAkciData;
use MASFB\Web\Value\Content\Data\KategorieKalendareData;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;

#[AsTwigComponent]
readonly final class KalendarAkci
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @param array<KategorieKalendareData> $kategorie
     * @return array<KalendarAkciData>
     */
    public function getItems(array $kategorie): array
    {
        $categorySlugs = [];
        foreach ($kategorie as $category) {
            $categorySlugs[] = $category->slug;
        }

        if ($kategorie === []) {
            return $this->content->getKalendarAkciData();
        }

        return $this->content->getKalendarAkciForCategoriesData(category: $categorySlugs, limit: 3);
    }
}
