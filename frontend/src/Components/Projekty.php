<?php

declare(strict_types=1);

namespace MASFB\Web\Components;

use MASFB\Web\Value\Content\Data\ProjektyKategorieData;
use MASFB\Web\Value\Content\Data\ProjektyObecData;
use MASFB\Web\Value\Content\Data\ProjektyOperacniProgramData;
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

    /**
     * @return array<ProjektyObecData>
     */
    public function getObce(): array
    {
        return $this->content->getProjektyObce();
    }

    /**
     * @return array<ProjektyKategorieData>
     */
    public function getKategorie(): array
    {
        return $this->content->getProjektyKategorie();
    }

    /**
     * @return array<ProjektyOperacniProgramData>
     */
    public function getOperacniProgramy(): array
    {
        return $this->content->getProjektyOperacniProgramy();
    }
}
