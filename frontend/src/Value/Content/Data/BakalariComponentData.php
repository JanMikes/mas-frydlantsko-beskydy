<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

readonly final class BakalariComponentData
{
    /**
     * @param array{} $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self();
    }
}
