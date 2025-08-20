<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type KategorieKalendareDataArray from KategorieKalendareData
 */
readonly final class KalendarAkciComponentData
{
    public function __construct(
        /** @var array<KategorieKalendareData> $Kategorie */
        public array $Kategorie,
    ) {}

    /**
     * @param array{
     *     Kategorie: array<KategorieKalendareDataArray>,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            KategorieKalendareData::createManyFromStrapiResponse($data['Kategorie']),
        );
    }
}
