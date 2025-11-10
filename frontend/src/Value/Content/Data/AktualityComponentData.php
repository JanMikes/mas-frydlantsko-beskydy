<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type TagDataArray from TagData
 */
readonly final class AktualityComponentData
{
    /**
     * @param array<TagData> $kategorie
     */
    public function __construct(
        public int $Pocet,
        public array $kategorie,
        public null|string $TextTlacitkaVsechnyAktuality,
    ) {}

    /**
     * @param array{
     *     Pocet: int,
     *     kategories: array<TagDataArray>,
     *     Text_tlacitka_vsechny_aktuality?: null|string,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Pocet: $data['Pocet'],
            kategorie: TagData::createManyFromStrapiResponse($data['kategories']),
            TextTlacitkaVsechnyAktuality: $data['Text_tlacitka_vsechny_aktuality'] ?? null,
        );
    }
}
