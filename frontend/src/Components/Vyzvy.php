<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\VyzvaData;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use MASFB\Web\Services\Strapi\StrapiContent;

#[AsTwigComponent]
readonly final class Vyzvy
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @return array<VyzvaData>
     */
    public function getItems(): array
    {
        return $this->content->getVyzvy();
    }
}
