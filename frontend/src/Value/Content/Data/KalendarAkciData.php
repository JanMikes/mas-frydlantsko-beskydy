<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

use DateTimeImmutable;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type AktualitaDataArray from AktualitaData
 * @phpstan-type KalendarAkciDataArray array{
 *     Datum: null|string,
 *     Nazev: null|string,
 *     Poradatel: null|string,
 *     Popis: null|string,
 *     Fotka: null|ImageDataArray,
 *     Aktualita: null|AktualitaDataArray,
 * }
 */
readonly final class KalendarAkciData
{
    /** @use CanCreateManyFromStrapiResponse<KalendarAkciDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|DateTimeImmutable $Datum,
        public null|string $Nazev,
        public null|string $Poradatel,
        public null|string $Popis,
        public null|ImageData $Fotka,
        public null|AktualitaData $Aktualita,
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

        return new self(
            Datum: $datum,
            Nazev: $data['Nazev'],
            Poradatel: $data['Poradatel'],
            Popis: $data['Popis'],
            Fotka: $data['Fotka'] !== null ? ImageData::createFromStrapiResponse($data['Fotka']) : null,
            Aktualita: $data['Aktualita'] !== null ? AktualitaData::createFromStrapiResponse($data['Aktualita']) : null,
        );
    }
}
