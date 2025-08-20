<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;
use MASFB\Web\Value\Content\Data\KategorieUredniDeskyData;
use MASFB\Web\Value\Content\Data\TagData;
use MASFB\Web\Value\Content\Data\UredniDeskaData;

#[AsTwigComponent]
readonly final class KalendarAkci
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @param array<KategorieUredniDeskyData> $kategorie
     * @return array<UredniDeskaData>
     */
    public function getItems(array $kategorie): array
    {
        $categorySlugs = [];
        foreach ($kategorie as $category) {
            $categorySlugs[] = $category->slug;
        }

        return $this->content->getKalendarAkciForCategoriesData(category: $categorySlugs, limit: 3);
    }
}
