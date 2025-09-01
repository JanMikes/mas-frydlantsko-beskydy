<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\VyzvaComponentData;
use MASFB\Web\Value\Content\Data\VyzvaData;
use MASFB\Web\Value\Content\Data\VyzvyKategorieData;
use MASFB\Web\Services\Strapi\StrapiContent;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Vyzvy
{
    public null|VyzvaComponentData $data = null;

    public function __construct(
        readonly private StrapiContent $content,
    ) {
    }

    /**
     * @return array<VyzvyKategorieData>
     */
    public function getKategorieItems(): array
    {
        return $this->content->getVyzvyKategorie();
    }

    /**
     * @return array<VyzvaData>
     */
    public function getItems(): array
    {
        return $this->content->getVyzvy(null, false);
    }
}
