<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

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

#[AsLiveComponent]
final class Projekty
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $sortBy = 'Nejoblíbenější';

    #[LiveProp(writable: true)]
    public null|string $kategorie = null;

    #[LiveProp(writable: true)]
    public null|string $operacniProgram = null;

    #[LiveProp(writable: true)]
    public null|string $obec = null;

    public null|ProjektyComponentData $data = null;

    public function __construct(
        readonly private StrapiContent $content,
    ) {
    }

    #[LiveAction]
    public function sort(#[LiveArg] string $sort): void
    {
        $this->sortBy = $sort;
    }

    /**
     * @return array<ProjektData>
     */
    public function getItems(): array
    {
        return $this->content->getProjektyData(
            $this->sortBy,
            $this->kategorie,
            $this->operacniProgram,
            $this->obec,
        );
    }

    /**
     * @return array<ProjektyObecData>
     */
    public function getObceItems(): array
    {
        return $this->content->getProjektyObce();
    }

    /**
     * @return array<VyzvyKategorieData>
     */
    public function getKategorieItems(): array
    {
        return $this->content->getVyzvyKategorie();
    }

    /**
     * @return array<VyzvyOperacniProgramData>
     */
    public function getOperacniProgramyItems(): array
    {
        return $this->content->getVyzvyOperacniProgramy();
    }
}
