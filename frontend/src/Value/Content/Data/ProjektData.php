<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-type ProjektDataArray array{
 *      Nazev: null|string,
 *      slug: null|string,
 *      Operacni_program: null|string,
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
        public null|string $Operacniprogram,
        public null|string $Prijemcedotace,
        public null|int $Vysedotace,
        public null|bool $Projektmasfb,
        public null|string $Dobarealizace,
        public null|ImageData $Obrazek,
        public null|string $Text,
    ) {}

    /**
     * @param ProjektDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $obrazek = $data['Obrazek'] !== null ? ImageData::createFromStrapiResponse($data['Obrazek']) : null;

        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
            Operacniprogram: $data['Operacni_program'],
            Prijemcedotace: $data['Prijemce_dotace'],
            Vysedotace: $data['Vyse_dotace'],
            Projektmasfb: $data['Projekt_mas_fb'],
            Dobarealizace: $data['Doba_realizace'],
            Obrazek: $obrazek,
            Text: $data['Text'],
        );
    }
}
