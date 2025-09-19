<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\PaginationMeta;
use MASFB\Web\Value\Content\Data\ProjektyComponentData;
use MASFB\Web\Value\Content\Data\ProjektyObecData;
use MASFB\Web\Value\Content\Data\VyzvyKategorieData;
use MASFB\Web\Value\Content\Data\VyzvyOperacniProgramData;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use MASFB\Web\Services\Strapi\StrapiContent;
use MASFB\Web\Value\Content\Data\ProjektData;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsLiveComponent]
final class Projekty
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $sortBy = 'Nejnovější';

    #[LiveProp(writable: true)]
    public int $page = 1;

    #[LiveProp(writable: true)]
    public null|string $kategorie = null;

    #[LiveProp(writable: true)]
    public null|string $operacniProgram = null;

    #[LiveProp(writable: true)]
    public null|string $obec = null;

    public null|ProjektyComponentData $data = null;

    /**
     * @var array<ProjektData>
     */
    public array $items = [];

    public null|PaginationMeta $paginationMeta = null;

    /**
     * @var array<ProjektyObecData>
     */
    public array $obceItems = [];

    /**
     * @var array<VyzvyKategorieData>
     */
    public array $kategorieItems = [];

    /**
     * @var array<VyzvyOperacniProgramData>
     */
    public array $operacniProgramyItems = [];

    public function __construct(
        readonly private StrapiContent $content,
    ) {
    }

    #[LiveAction]
    public function sort(#[LiveArg] string $sort): void
    {
        $this->sortBy = $sort;
        $this->page = 1;
    }

    #[LiveAction]
    public function changePage(#[LiveArg] int $page): void
    {
        $this->page = $page;
    }

    #[PostMount]
    public function populateData(): void
    {
        $kategorie = $this->data?->kategorie->slug ?? $this->kategorie;

        [$this->items, $this->paginationMeta] = $this->content->getProjektyData(
            $this->sortBy,
            $kategorie,
            $this->operacniProgram,
            $this->obec,
            start: ($this->page - 1) * 50,
        );

        $this->obceItems = $this->content->getProjektyObce();
        $this->kategorieItems = $this->content->getVyzvyKategorie();
        $this->operacniProgramyItems = $this->content->getVyzvyOperacniProgramy();
    }
}
