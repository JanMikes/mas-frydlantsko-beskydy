<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-type HistorieDataArray array{
 *     Nadpis: string,
 *     Text: null|string,
 *     Fotka: null|ImageDataArray,
 * }
 */
readonly final class HistorieData
{
    /** @use CanCreateManyFromStrapiResponse<HistorieDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Nadpis,
        public string $Text,
        public null|ImageData $Fotka,
    ) {
    }

    /**
     * @param HistorieDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Text: $data['Text'] ?? '',
            Fotka: $data['Fotka'] !== null ? ImageData::createFromStrapiResponse($data['Fotka']) : null,
        );
    }
}
