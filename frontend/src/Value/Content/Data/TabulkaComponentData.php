<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type RadekTabulkyDataArray from RadekTabulkyData
 * @phpstan-type TabulkaComponentDataArray array{
 *     Nadpis_sloupec_1: null|string,
 *     Nadpis_sloupec_2: null|string,
 *     Nadpis_sloupec_3: null|string,
 *     Nadpis_sloupec_4: null|string,
 *     Radky: array<RadekTabulkyDataArray>,
 * }
 */
readonly final class TabulkaComponentData
{
    public function __construct(
        public null|string $Nadpis1,
        public null|string $Nadpis2,
        public null|string $Nadpis3,
        public null|string $Nadpis4,
        /** @var array<RadekTabulkyData> */
        public array $Radky,
    )
    {
    }

    /**
     * @param TabulkaComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis1: $data['Nadpis_sloupec_1'],
            Nadpis2: $data['Nadpis_sloupec_2'],
            Nadpis3: $data['Nadpis_sloupec_3'],
            Nadpis4: $data['Nadpis_sloupec_4'],
            Radky: RadekTabulkyData::createManyFromStrapiResponse($data['Radky']),
        );
    }
}
