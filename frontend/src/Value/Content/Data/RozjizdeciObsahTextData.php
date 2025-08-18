<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type RozjizdeciObsahTextDataArray array{
 *     Nadpis: string|null,
 *     Text: string|null,
 * }
 */
readonly final class RozjizdeciObsahTextData
{
    public function __construct(
        public null|string $Nadpis,
        public null|string $Text,
    ) {}

    /**
     * @param RozjizdeciObsahTextDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Nadpis'],
            $data['Text'],
        );
    }
}
