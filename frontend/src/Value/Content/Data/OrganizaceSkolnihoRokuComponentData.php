<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type OrganizaceSkolnihoRokuDataArray from OrganizaceSkolnihoRokuData
 */
readonly final class OrganizaceSkolnihoRokuComponentData
{
    /**
     * @param array<OrganizaceSkolnihoRokuData> $items
     */
    public function __construct(
        public array $items,
    ) {}

    /**
     * @param array{
     *     Polozky: array<OrganizaceSkolnihoRokuDataArray>,
     * } $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            items: OrganizaceSkolnihoRokuData::createManyFromStrapiResponse($data['Polozky']),
        );
    }
}
