<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type FileDataArray from FileData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-type SouborDataArray array{
 *     Nadpis: string,
 *     Soubor: FileDataArray,
 *     Tag: null|TagDataArray,
 * }
 */
readonly final class SouborData
{
    /** @use CanCreateManyFromStrapiResponse<SouborDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Nadpis,
        public FileData $Soubor,
        public null|TagData $Tag,
    ) {
    }

    /**
     * @param SouborDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Soubor: FileData::createFromStrapiResponse($data['Soubor']),
            Tag: $data['Tag'] !== null ? TagData::createFromStrapiResponse($data['Tag']) : null,
        );
    }
}
