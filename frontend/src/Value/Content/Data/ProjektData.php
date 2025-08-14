<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type ProjektyKategorieDataArray from ProjektyKategorieData
 * @phpstan-import-type ProjektyObecDataArray from ProjektyObecData
 * @phpstan-import-type ProjektyOperacniProgramDataArray from ProjektyOperacniProgramData
 * @phpstan-type ProjektDataArray array{
 *      Nazev: null|string,
 *      slug: null|string,
 *      Operacni_program: null|ProjektyOperacniProgramDataArray,
 *      Obec: null|ProjektyObecDataArray,
 *      Kategorie: null|ProjektyKategorieDataArray,
 *      Prijemce_dotace: null|string,
 *      Vyse_dotace: null|int,
 *      Projekt_mas_fb: null|bool,
 *      Doba_realizace: null|string,
 *      Obrazek: null|ImageDataArray,
 *      Text: null|string,
 *  }
 */
readonly final class ProjektData
{
    /** @use CanCreateManyFromStrapiResponse<ProjektDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
        public null|string $slug,
        public null|ProjektyOperacniProgramData $OperacniProgram,
        public null|ProjektyObecData $Obec,
        public null|ProjektyKategorieData $Kategorie,
        public null|string $PrijemceDotace,
        public null|int $VyseDotace,
        public null|bool $ProjektMasFb,
        public null|string $DobaRealizace,
        public null|ImageData $Obrazek,
        public null|string $Text,
    ) {}

    /**
     * @param ProjektDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $obrazek = $data['Obrazek'] !== null ? ImageData::createFromStrapiResponse($data['Obrazek']) : null;
        $operacniProgram = $data['Operacni_program'] !== null ? ProjektyOperacniProgramData::createFromStrapiResponse($data['Operacni_program']) : null;
        $obec = $data['Obec'] !== null ? ProjektyObecData::createFromStrapiResponse($data['Obec']) : null;
        $kategorie = $data['Kategorie'] !== null ? ProjektyKategorieData::createFromStrapiResponse($data['Kategorie']) : null;

        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
            OperacniProgram: $operacniProgram,
            Obec: $obec,
            Kategorie: $kategorie,
            PrijemceDotace: $data['Prijemce_dotace'],
            VyseDotace: $data['Vyse_dotace'],
            ProjektMasFb: $data['Projekt_mas_fb'],
            DobaRealizace: $data['Doba_realizace'],
            Obrazek: $obrazek,
            Text: $data['Text'],
        );
    }
}
