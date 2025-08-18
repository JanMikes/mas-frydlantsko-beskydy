<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type VyzvyOperacniProgramDataArray from VyzvyOperacniProgramData
 * @phpstan-import-type ClovekSamospravyDataArray from ClovekSamospravyData
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-type VyzvaDataArray array{
 *     Nazev: null|string,
 *     zahajeni_vyzvy: null|string,
 *     zahajeni_prijmu_zadosti: null|string,
 *     konec_vyzvy: null|string,
 *     financni_alokace: null|int,
 *     minimalni_vyse_nakladu: null|int,
 *     maximalni_vyse_nakladu: null|int,
 *     zdroj_financovani: null|VyzvyOperacniProgramDataArray,
 *     opatreni_sclld: null|string,
 *     opravneni_zadatele: null|string,
 *     informace: null|string,
 *     Lide: null|array{Lide: array<ClovekSamospravyDataArray>},
 *     Dokumenty: null|array{Pocet_sloupcu: string, Soubor: array<SouborDataArray>},
 * }
 */
readonly final class VyzvaData
{
    /** @use CanCreateManyFromStrapiResponse<VyzvaDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
        public null|string $ZahajeniVyzvy,
        public null|string $ZahajeniPrijmuZadosti,
        public null|string $KonecVyzvy,
        public null|int $FinancniAlokace,
        public null|int $MinimalniVyseNakladu,
        public null|int $MaximalniVyseNakladu,
        public null|VyzvyOperacniProgramData $ZdrojFinancovani,
        public null|string $OpatreniSclld,
        public null|string $OpravneniZadatele,
        public null|string $Informace,
        public null|SamospravaComponentData $Lide,
        public null|SouboryKeStazeniComponentData $Dokumenty,
    ) {
    }

    /**
     * @param VyzvaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
            ZahajeniVyzvy: $data['zahajeni_vyzvy'],
            ZahajeniPrijmuZadosti: $data['zahajeni_prijmu_zadosti'],
            KonecVyzvy: $data['konec_vyzvy'],
            FinancniAlokace: $data['financni_alokace'],
            MinimalniVyseNakladu: $data['minimalni_vyse_nakladu'],
            MaximalniVyseNakladu: $data['maximalni_vyse_nakladu'],
            ZdrojFinancovani: $data['zdroj_financovani'] === null 
                ? null 
                : VyzvyOperacniProgramData::createFromStrapiResponse($data['zdroj_financovani']),
            OpatreniSclld: $data['opatreni_sclld'],
            OpravneniZadatele: $data['opravneni_zadatele'],
            Informace: $data['informace'],
            Lide: $data['Lide'] === null 
                ? null 
                : SamospravaComponentData::createFromStrapiResponse($data['Lide']),
            Dokumenty: $data['Dokumenty'] === null 
                ? null 
                : SouboryKeStazeniComponentData::createFromStrapiResponse($data['Dokumenty']),
        );
    }
}