<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type IkonkaDataArray from IkonkaData
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type IkonkaSOdkazemDataArray array{
 *     Ikonka: null|IkonkaDataArray,
 *     Text: null|string,
 *     Odkaz: null|OdkazDataArray,
 * }
 */
readonly final class IkonkaSOdkazemData
{
    /** @use CanCreateManyFromStrapiResponse<IkonkaSOdkazemDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|IkonkaData $Ikonka,
        public null|string $Text,
        public null|OdkazData $Odkaz,
    ) {
    }

    /**
     * @param IkonkaSOdkazemDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Ikonka: $data['Ikonka'] !== null ? IkonkaData::createFromStrapiResponse($data['Ikonka']) : null,
            Text: $data['Text'],
            Odkaz: $data['Odkaz'] !== null ? OdkazData::createFromStrapiResponse($data['Odkaz']) : null,
        );
    }
}
