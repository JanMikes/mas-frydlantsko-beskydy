<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

use DateTimeImmutable;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type FileDataArray from FileData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-import-type ClovekDataArray from ClovekData
 * @phpstan-type AktualitaDataArray array{
 *      Nadpis: string,
 *      Datum_zverejneni: string,
 *      Video_youtube: null|string,
 *      Popis: null|string,
 *      Zobrazovat: bool,
 *      slug: string,
 *      Obrazek?: null|ImageDataArray,
 *      Galerie?: null|array<ImageDataArray>,
 *      Zverejnil?: null|ClovekDataArray,
 *      tags?: array<TagDataArray>,
 *      Soubory?: null|array<FileDataArray>,
 *      Souvisejici_aktuality: array<mixed>,
 *  }
 */
readonly final class AktualitaData
{
    /** @use CanCreateManyFromStrapiResponse<AktualitaDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<ImageData> $Galerie
     * @param array<TagData> $Tagy
     * @param array<FileData> $Soubory
     * @param array<AktualitaData> $SouvisejiciAktuality
     */
    public function __construct(
        public string $Nadpis,
        public DateTimeImmutable $DatumZverejneni,
        public null|ImageData $Obrazek,
        public string|null $Video_youtube,
        public array $Galerie,
        public ClovekData|null $Zverejnil,
        public array $Tagy,
        public string $Popis,
        public null|string $slug,
        public array $Soubory,
        public array $SouvisejiciAktuality,
    ) {}

    /**
     * @param AktualitaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $datumZverejneni = new DateTimeImmutable($data['Datum_zverejneni']);
        $tags = TagData::createManyFromStrapiResponse($data['tags'] ?? []);
        $zverejnil = ($data['Zverejnil'] ?? null) !== null ? ClovekData::createFromStrapiResponse($data['Zverejnil']) : null;
        $soubory = FileData::createManyFromStrapiResponse($data['Soubory'] ?? []);
        $galerie = ImageData::createManyFromStrapiResponse($data['Galerie'] ?? []);
        $obrazek = ($data['Obrazek'] ?? null) !== null ? ImageData::createFromStrapiResponse($data['Obrazek']) : null;

        /** @phpstan-ignore-next-line */
        $souvisejiciAktuality = self::createManyFromStrapiResponse($data['Souvisejici_aktuality'] ?? []);

        return new self(
            $data['Nadpis'],
            $datumZverejneni,
            $obrazek,
            $data['Video_youtube'],
            $galerie,
            $zverejnil,
            $tags,
            $data['Popis'] ?? '',
            $data['slug'],
            $soubory,
            $souvisejiciAktuality,
        );
    }
}
