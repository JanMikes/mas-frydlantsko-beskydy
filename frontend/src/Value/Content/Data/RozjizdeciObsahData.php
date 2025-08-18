<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ClovekSamospravyDataArray from ClovekSamospravyData
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-import-type VyzvaDataArray from VyzvaData
 * @phpstan-type RozjizdeciObsahDataArray array{
 *     Nadpis: null|string,
 *     Text: null|string,
 *     Lide: null|array{Lide: array<ClovekSamospravyDataArray>},
 *     Dokumenty: null|array{Pocet_sloupcu: string, Soubor: array<SouborDataArray>},
 *     Vyzva: null|VyzvaDataArray,
 * }
 */
readonly final class RozjizdeciObsahData
{
    public function __construct(
        public null|string $Nadpis,
        public null|string $Text,
        public null|SamospravaComponentData $Lide,
        public null|SouboryKeStazeniComponentData $Dokumenty,
        public null|VyzvaData $Vyzva,
    ) {
    }

    /**
     * @param RozjizdeciObsahDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Text: $data['Text'],
            Lide: $data['Lide'] === null 
                ? null 
                : SamospravaComponentData::createFromStrapiResponse($data['Lide']),
            Dokumenty: $data['Dokumenty'] === null 
                ? null 
                : SouboryKeStazeniComponentData::createFromStrapiResponse($data['Dokumenty']),
            Vyzva: $data['Vyzva'] === null 
                ? null 
                : VyzvaData::createFromStrapiResponse($data['Vyzva']),
        );
    }
}
