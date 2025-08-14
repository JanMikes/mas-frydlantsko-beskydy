<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;
use MASFB\Web\Value\Content\Data\ProjektData;

#[AsTwigComponent]
readonly final class Projekty
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @return array<ProjektData>
     */
    public function getItems(): array
    {
        return $this->content->getProjektyData();
    }
}