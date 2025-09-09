<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\ProjektData;
use MASFB\Web\Value\Content\Data\VyzvaComponentData;
use MASFB\Web\Value\Content\Data\VyzvaData;
use MASFB\Web\Value\Content\Data\VyzvyKategorieData;
use MASFB\Web\Services\Strapi\StrapiContent;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Vyzvy
{
    use DefaultActionTrait;

    /**
     * @var array<string>
     */
    #[LiveProp(writable: true)]
    public array $categories = [];

    public null|VyzvaComponentData $data = null;

    public function __construct(
        readonly private StrapiContent $content,
    ) {
    }

    #[LiveAction]
    public function clearFilters(): void
    {
        $this->categories = [];
    }

    #[LiveAction]
    public function toggleCategory(#[LiveArg] string $categorySlug): void
    {
        if (in_array($categorySlug, $this->categories, true)) {
            $this->categories = array_values(array_filter($this->categories, fn(string $slug): bool => $slug !== $categorySlug));
        } else {
            $this->categories[] = $categorySlug;
        }
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
        return $this->content->getVyzvy($this->categories, false);
    }

    /**
     * @return array<ProjektData>
     */
    public function getPodporeneProjekty(): array
    {
        return $this->content->getProjektyData(
            'Nejnovější',
            $this->categories,
            null,
            null,
        );
    }
}
