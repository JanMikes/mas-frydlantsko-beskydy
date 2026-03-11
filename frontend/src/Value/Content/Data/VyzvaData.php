<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type VyzvyOperacniProgramDataArray from VyzvyOperacniProgramData
 * @phpstan-import-type SamospravaComponentDataArray from SamospravaComponentData
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-import-type VyzvyKategorieDataArray from VyzvyKategorieData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-type VyzvaDataArray array{
 *     Nazev: null|string,
 *     Zahajeni_vyzvy: null|string,
 *     Zobrazit_cas_zahajeni_vyzvy: null|bool,
 *     Zahajeni_prijmu_zadosti: null|string,
 *     Zobrazit_cas_zahajeni_prijmu_zadosti: null|bool,
 *     Ukonceni_prijmu_zadosti: null|string,
 *     Zobrazit_cas_ukonceni_prijmu_zadosti: null|bool,
 *     Konec_vyzvy: null|string,
 *     Zobrazit_cas_konec_vyzvy: null|bool,
 *     Financni_alokace: null|int,
 *     Minimalni_vyse_nakladu: null|int,
 *     Maximalni_vyse_nakladu: null|int,
 *     Operacni_program: null|VyzvyOperacniProgramDataArray,
 *     Opatreni_sclld: null|string,
 *     Opravneni_zadatele: null|string,
 *     Informace: null|string,
 *     Lide: null|SamospravaComponentDataArray,
 *     Dokumenty: null|array{Pocet_sloupcu: string, Soubor: array<SouborDataArray>},
 *     slug: null|string,
 *     Kategorie: array<VyzvyKategorieDataArray>,
 *     Tagy?: array<TagDataArray>,
 * }
 */
readonly final class VyzvaData
{
    /** @use CanCreateManyFromStrapiResponse<VyzvaDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<VyzvyKategorieData> $Kategorie
     * @param array<TagData> $Tagy
     */
    public function __construct(
        public null|string $Nazev,
        public null|string $ZahajeniVyzvy,
        public null|bool $ZobrazitCasZahajeniVyzvy,
        public null|string $ZahajeniPrijmuZadosti,
        public null|bool $ZobrazitCasZahajeniPrijmuZadosti,
        public null|string $UkonceniPrijmuZadosti,
        public null|bool $ZobrazitCasUkonceniPrijmuZadosti,
        public null|string $KonecVyzvy,
        public null|bool $ZobrazitCasKonecVyzvy,
        public null|int $FinancniAlokace,
        public null|int $MinimalniVyseNakladu,
        public null|int $MaximalniVyseNakladu,
        public null|VyzvyOperacniProgramData $OperacniProgram,
        public null|string $OpatreniSclld,
        public null|string $OpravneniZadatele,
        public null|string $Informace,
        public null|SamospravaComponentData $Lide,
        public null|SouboryKeStazeniComponentData $Dokumenty,
        public null|string $slug,
        public array $Kategorie,
        public array $Tagy,
    ) {
    }

    /**
     * @param VyzvaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $tags = TagData::createManyFromStrapiResponse($data['Tagy'] ?? []);

        return new self(
            Nazev: $data['Nazev'],
            ZahajeniVyzvy: $data['Zahajeni_vyzvy'],
            ZobrazitCasZahajeniVyzvy: $data['Zobrazit_cas_zahajeni_vyzvy'] ?? true,
            ZahajeniPrijmuZadosti: $data['Zahajeni_prijmu_zadosti'],
            ZobrazitCasZahajeniPrijmuZadosti: $data['Zobrazit_cas_zahajeni_prijmu_zadosti'] ?? true,
            UkonceniPrijmuZadosti: $data['Ukonceni_prijmu_zadosti'] ?? null,
            ZobrazitCasUkonceniPrijmuZadosti: $data['Zobrazit_cas_ukonceni_prijmu_zadosti'] ?? true,
            KonecVyzvy: $data['Konec_vyzvy'],
            ZobrazitCasKonecVyzvy: $data['Zobrazit_cas_konec_vyzvy'] ?? true,
            FinancniAlokace: $data['Financni_alokace'],
            MinimalniVyseNakladu: $data['Minimalni_vyse_nakladu'],
            MaximalniVyseNakladu: $data['Maximalni_vyse_nakladu'],
            OperacniProgram: $data['Operacni_program'] === null
                ? null 
                : VyzvyOperacniProgramData::createFromStrapiResponse($data['Operacni_program']),
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
            Kategorie: VyzvyKategorieData::createManyFromStrapiResponse($data['Kategorie']),
            Tagy: $tags,
        );
    }
}
