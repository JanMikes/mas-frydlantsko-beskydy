<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type FaqDataArray array{
 *      Otazka: string,
 *      Odpoved: string,
 *  }
 */
readonly final class FaqData
{
    /** @use CanCreateManyFromStrapiResponse<FaqDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Otazka,
        public string $Odpoved,
    ) {}

    /**
     * @param FaqDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Otazka: $data['Otazka'],
            Odpoved: $data['Odpoved'],
        );
    }
}
