<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type MenuDataArray array{
 *     Nadpis: string,
 *     Odkaz: OdkazDataArray,
 *     Navbar: null|bool,
 *     Footer: null|bool,
 *     Sidebar: null|bool,
 * }
 */
readonly final class MenuData
{
    /** @use CanCreateManyFromStrapiResponse<MenuDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Nadpis,
        public OdkazData $Odkaz,
        public bool $Navbar,
        public bool $Footer,
        public bool $Sidebar,
    ) {
    }

    /**
     * @param MenuDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nadpis: $data['Nadpis'],
            Odkaz: OdkazData::createFromStrapiResponse($data['Odkaz']),
            Navbar: $data['Navbar'] ?? false,
            Footer: $data['Footer'] ?? false,
            Sidebar: $data['Sidebar'] ?? false,
        );
    }
}
