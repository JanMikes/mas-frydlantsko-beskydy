<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

use DateTimeImmutable;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type GalerieComponentDataArray from GalerieComponentData
 * @phpstan-import-type SouboryKeStazeniComponentDataArray from SouboryKeStazeniComponentData
 * @phpstan-import-type FileDataArray from FileData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-type KalendarAkciDataArray array{
 *     Datum: null|string,
 *     Nazev: null|string,
 *     Poradatel: null|string,
 *     Misto_konani: null|string,
 *     Popis: null|string,
 *     Fotka: null|ImageDataArray,
 *     Fotka_detail: null|ImageDataArray,
 *     Video_youtube: null|string,
 *     Galerie: null|GalerieComponentDataArray,
 *     Tagy?: array<TagDataArray>,
 *     Dokumenty: null|SouboryKeStazeniComponentDataArray,
 * }
 */
readonly final class KalendarAkciData
{
    /** @use CanCreateManyFromStrapiResponse<KalendarAkciDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<TagData> $Tagy
     */
    public function __construct(
        public null|DateTimeImmutable $Datum,
        public null|string $Nazev,
        public null|string $Poradatel,
        public null|string $Popis,
        public null|string $MistoKonani,
        public null|ImageData $Fotka,
        public null|ImageData $FotkaDetail,
        public string|null $VideoYoutube,
        public null|GalerieComponentData $Galerie,
        public array $Tagy,
        public null|SouboryKeStazeniComponentData $Dokumenty,
    ) {
    }

    /**
     * @param KalendarAkciDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $datum = null;

        if ($data['Datum']) {
            $datum = new DateTimeImmutable($data['Datum']);
        }

        $gallery = null;
        if ($data['Galerie'] !== null) {
            $gallery = GalerieComponentData::createFromStrapiResponse($data['Galerie']);
        }

        $documents = null;
        if ($data['Dokumenty'] !== null) {
            $documents = SouboryKeStazeniComponentData::createFromStrapiResponse($data['Dokumenty']);
        }

        $tags = TagData::createManyFromStrapiResponse($data['Tagy'] ?? []);

        return new self(
            Datum: $datum,
            Nazev: $data['Nazev'],
            Poradatel: $data['Poradatel'],
            Popis: $data['Popis'],
            MistoKonani: $data['Misto_konani'],
            Fotka: $data['Fotka'] !== null ? ImageData::createFromStrapiResponse($data['Fotka']) : null,
            FotkaDetail: $data['Fotka_detail'] !== null ? ImageData::createFromStrapiResponse($data['Fotka_detail']) : null,
            VideoYoutube: $data['Video_youtube'],
            Galerie: $gallery,
            Tagy: $tags,
            Dokumenty: $documents,
        );
    }
}
