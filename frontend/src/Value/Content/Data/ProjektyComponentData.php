<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

readonly final class ProjektyComponentData
{
    public function __construct()
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self();
    }
}
