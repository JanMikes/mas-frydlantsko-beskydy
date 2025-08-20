<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type VyzvyOperacniProgramDataArray from VyzvyOperacniProgramData
 * @phpstan-import-type ClovekSamospravyDataArray from ClovekSamospravyData
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-type VyzvaDataArray array{
 *     Nazev: null|string,
 *     Zahajeni_vyzvy: null|string,
 *     Zahajeni_prijmu_zadosti: null|string,
 *     Konec_vyzvy: null|string,
 *     Financni_alokace: null|int,
 *     Minimalni_vyse_nakladu: null|int,
 *     Maximalni_vyse_nakladu: null|int,
 *     Zdroj_financovani: null|VyzvyOperacniProgramDataArray,
 *     Opatreni_sclld: null|string,
 *     Opravneni_zadatele: null|string,
 *     Informace: null|string,
 *     Lide: null|array{Lide: array<ClovekSamospravyDataArray>},
 *     Dokumenty: null|array{Pocet_sloupcu: string, Soubor: array<SouborDataArray>},
 *     slug: null|string,
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
        public null|string $slug,
    ) {
    }

    /**
     * @param VyzvaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
            ZahajeniVyzvy: $data['Zahajeni_vyzvy'],
            ZahajeniPrijmuZadosti: $data['Zahajeni_prijmu_zadosti'],
            KonecVyzvy: $data['Konec_vyzvy'],
            FinancniAlokace: $data['Financni_alokace'],
            MinimalniVyseNakladu: $data['Minimalni_vyse_nakladu'],
            MaximalniVyseNakladu: $data['Maximalni_vyse_nakladu'],
            ZdrojFinancovani: $data['Zdroj_financovani'] === null
                ? null 
                : VyzvyOperacniProgramData::createFromStrapiResponse($data['Zdroj_financovani']),
            OpatreniSclld: $data['Opatreni_sclld'],
            OpravneniZadatele: $data['Opravneni_zadatele'],
            Informace: $data['Informace'],
            Lide: $data['Lide'] === null 
                ? null 
                : SamospravaComponentData::createFromStrapiResponse($data['Lide']),
            Dokumenty: $data['Dokumenty'] === null 
                ? null 
                : SouboryKeStazeniComponentData::createFromStrapiResponse($data['Dokumenty']),
            slug: $data['slug'],
        );
    }
}
