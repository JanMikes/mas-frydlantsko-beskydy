<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type OdkazSTextemDataArray array{
 *     Text: null|string,
 *     Odkaz: null|OdkazDataArray,
 * }
 */
readonly final class OdkazSTextemData
{
    /** @use CanCreateManyFromStrapiResponse<OdkazSTextemDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Text,
        public null|OdkazData $Odkaz,
    ) {
    }

    /**
     * @param OdkazSTextemDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Text: $data['Text'],
            Odkaz: $data['Odkaz'] !== null ? OdkazData::createFromStrapiResponse($data['Odkaz']) : null,
        );
    }
}
