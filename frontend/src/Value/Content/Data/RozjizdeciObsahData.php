<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type SamospravaComponentDataArray from SamospravaComponentData
 * @phpstan-import-type RozjizdeciObsahTextDataArray from RozjizdeciObsahTextData
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-import-type VyzvaDataArray from VyzvaData
 * @phpstan-import-type TlacitkoDataArray from TlacitkoData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-type RozjizdeciObsahDataArray array{
 *     Nadpis: null|string,
 *     Text: null|RozjizdeciObsahTextDataArray,
 *     Lide: null|SamospravaComponentDataArray,
 *     Dokumenty: null|array{Pocet_sloupcu: string, Soubor: array<SouborDataArray>},
 *     Vyzva: null|VyzvaDataArray,
 *     Tlacitko: null|TlacitkoDataArray,
 *     Tagy: array<TagDataArray>,
 * }
 */
readonly final class RozjizdeciObsahData
{
    /** @use CanCreateManyFromStrapiResponse<RozjizdeciObsahDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<TagData> $Tagy
     */
    public function __construct(
        public null|string $Nadpis,
        public null|RozjizdeciObsahTextData $Text,
        public null|SamospravaComponentData $Lide,
        public null|SouboryKeStazeniComponentData $Dokumenty,
        public null|VyzvaData $Vyzva,
        public null|TlacitkoData $Tlacitko,
        public array $Tagy,
    ) {
    }

    /**
     * @param RozjizdeciObsahDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $tags = TagData::createManyFromStrapiResponse($data['Tagy']);

        return new self(
            Nadpis: $data['Nadpis'],
            Text: $data['Text'] === null
                ? null
                : RozjizdeciObsahTextData::createFromStrapiResponse($data['Text']),
            Lide: $data['Lide'] === null 
                ? null 
                : SamospravaComponentData::createFromStrapiResponse($data['Lide']),
            Dokumenty: $data['Dokumenty'] === null 
                ? null 
                : SouboryKeStazeniComponentData::createFromStrapiResponse($data['Dokumenty']),
            Vyzva: $data['Vyzva'] === null 
                ? null 
                : VyzvaData::createFromStrapiResponse($data['Vyzva']),
            Tlacitko: $data['Tlacitko'] === null
                ? null
                : TlacitkoData::createFromStrapiResponse($data['Tlacitko']),
            Tagy: $tags,
        );
    }
}
