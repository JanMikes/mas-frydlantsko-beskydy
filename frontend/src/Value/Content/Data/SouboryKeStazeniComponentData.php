<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-import-type SouborDataArray from SouborData
 * @phpstan-type SouboryKeStazeniComponentDataArray array{
 *      Pocet_sloupcu: string,
 *      Soubor: array<SouborDataArray>,
 *   }
 */
readonly final class SouboryKeStazeniComponentData
{
    /**
     * @var array<TagData>
     */
    public array $Tagy;

    /**
     * @param array<SouborData> $Soubor
     */
    public function __construct(
        public int $Pocet_sloupcu,
        public array $Soubor,
    ) {
        $Tagy = [];
        $existingSlugs = [];

        foreach ($this->Soubor as $soubor) {
            if ($soubor->Tag !== null && !in_array($soubor->Tag->slug, $existingSlugs, true)) {
                $Tagy[] = $soubor->Tag;
                $existingSlugs[] = $soubor->Tag->slug;
            }
        }

        $this->Tagy = $Tagy;
    }

    /**
     * @param SouboryKeStazeniComponentDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $pocetSloupcu = 1;

        if ($data['Pocet_sloupcu'] === 'Dva') {
            $pocetSloupcu = 2;
        }

        return new self(
            $pocetSloupcu,
            SouborData::createManyFromStrapiResponse($data['Soubor']),
        );
    }
}
