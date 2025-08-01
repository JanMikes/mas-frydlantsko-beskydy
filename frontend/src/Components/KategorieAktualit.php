<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\TagData;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;

#[AsTwigComponent]
readonly final class KategorieAktualit
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @return array<TagData>
     */
    public function getItems(): array
    {
        return $this->content->getTagy();
    }
}
