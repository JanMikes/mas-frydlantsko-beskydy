<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

readonly final class RozjizdeciObsahTextData
{
    public function __construct(
        public null|string $Nadpis,
        public null|string $Text,
    ) {}

    /**
     * @param array{Nadpis: string|null, Text: string|null} $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Nadpis'] ?? null,
            $data['Text'] ?? null,
        );
    }
}
