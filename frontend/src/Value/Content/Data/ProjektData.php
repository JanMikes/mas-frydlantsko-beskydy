<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type VyzvyKategorieDataArray from VyzvyKategorieData
 * @phpstan-import-type ProjektyObecDataArray from ProjektyObecData
 * @phpstan-import-type VyzvaDataArray from VyzvaData
 * @phpstan-type ProjektDataArray array{
 *      Nazev: null|string,
 *      slug: null|string,
 *      Vyzva: null|VyzvaDataArray,
 *      Obec: null|ProjektyObecDataArray,
 *      Kategorie: array<VyzvyKategorieDataArray>,
 *      Prijemce_dotace: null|string,
 *      Vyse_dotace: null|int,
 *      Projekt_mas_fb: null|bool,
 *      Doba_realizace: null|string,
 *      Obrazek: null|ImageDataArray,
 *      Text: null|string,
 *      Souvisejici_projekty: array<mixed>,
 *  }
 */
readonly final class ProjektData
{
    /** @use CanCreateManyFromStrapiResponse<ProjektDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<VyzvyKategorieData> $Kategorie
     * @param array<ProjektData> $SouvisejiciProjekty
     */
    public function __construct(
        public null|string $Nazev,
        public null|string $slug,
        public null|VyzvaData $Vyzva,
        public null|ProjektyObecData $Obec,
        public array $Kategorie,
        public null|string $PrijemceDotace,
        public null|int $VyseDotace,
        public null|bool $ProjektMasFb,
        public null|string $DobaRealizace,
        public null|ImageData $Obrazek,
        public null|string $Text,
        public array $SouvisejiciProjekty,
    ) {}

    /**
     * @param ProjektDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $obrazek = $data['Obrazek'] !== null ? ImageData::createFromStrapiResponse($data['Obrazek']) : null;
        $vyzva = $data['Vyzva'] !== null ? VyzvaData::createFromStrapiResponse($data['Vyzva']) : null;
        $obec = $data['Obec'] !== null ? ProjektyObecData::createFromStrapiResponse($data['Obec']) : null;

        /** @phpstan-ignore-next-line */
        $souvisejiciProjekty = self::createManyFromStrapiResponse($data['Souvisejici_projekty'] ?? []);

        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
            Vyzva: $vyzva,
            Obec: $obec,
            Kategorie: VyzvyKategorieData::createManyFromStrapiResponse($data['Kategorie']),
            PrijemceDotace: $data['Prijemce_dotace'],
            VyseDotace: $data['Vyse_dotace'],
            ProjektMasFb: $data['Projekt_mas_fb'],
            DobaRealizace: $data['Doba_realizace'],
            Obrazek: $obrazek,
            Text: $data['Text'],
            SouvisejiciProjekty: $souvisejiciProjekty,
        );
    }
}
