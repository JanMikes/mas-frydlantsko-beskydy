<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type OrganizaceSkolnihoRokuDataArray array{
 *      Nadpis: string,
 *      Text: string,
 *  }
 */
readonly final class OrganizaceSkolnihoRokuData
{
    /** @use CanCreateManyFromStrapiResponse<OrganizaceSkolnihoRokuDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Nadpis,
        public string $Text,
    ) {}

    /**
     * @param OrganizaceSkolnihoRokuDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Text: $data['Text'],
        );
    }
}
