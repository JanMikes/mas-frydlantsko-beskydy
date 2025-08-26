<?php

declare(strict_types=1);

namespace MASFB\Web\Services\Strapi;

use MASFB\Web\Value\Content\Data\FooterData;
use MASFB\Web\Value\Content\Data\HomepageData;
use MASFB\Web\Value\Content\Data\KalendarAkciData;
use MASFB\Web\Value\Content\Data\KategorieKalendareData;
use Psr\Clock\ClockInterface;
use MASFB\Web\Value\Content\Data\AktualitaData;
use MASFB\Web\Value\Content\Data\KategorieUredniDeskyData;
use MASFB\Web\Value\Content\Data\MenuData;
use MASFB\Web\Value\Content\Data\SekceData;
use MASFB\Web\Value\Content\Data\UredniDeskaData;
use MASFB\Web\Value\Content\Exception\NotFound;
use MASFB\Web\Value\Content\Data\ClovekData;
use MASFB\Web\Value\Content\Data\DlazdiceData;
use MASFB\Web\Value\Content\Data\FileData;
use MASFB\Web\Value\Content\Data\ImageData;
use MASFB\Web\Value\Content\Data\ProjektData;
use MASFB\Web\Value\Content\Data\ProjektyKategorieData;
use MASFB\Web\Value\Content\Data\ProjektyObecData;
use MASFB\Web\Value\Content\Data\VyzvyOperacniProgramData;
use MASFB\Web\Value\Content\Data\VyzvaData;
use MASFB\Web\Value\Content\Data\TagData;

/**
 * @phpstan-import-type AktualitaDataArray from AktualitaData
 * @phpstan-import-type ClovekDataArray from ClovekData
 * @phpstan-import-type DlazdiceDataArray from DlazdiceData
 * @phpstan-import-type FileDataArray from FileData
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type MenuDataArray from MenuData
 * @phpstan-import-type ProjektDataArray from ProjektData
 * @phpstan-import-type ProjektyKategorieDataArray from ProjektyKategorieData
 * @phpstan-import-type ProjektyObecDataArray from ProjektyObecData
 * @phpstan-import-type VyzvyOperacniProgramDataArray from VyzvyOperacniProgramData
 * @phpstan-import-type VyzvaDataArray from VyzvaData
 * @phpstan-import-type SekceDataArray from SekceData
 * @phpstan-import-type HomepageDataArray from HomepageData
 * @phpstan-import-type FooterDataArray from FooterData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-import-type UredniDeskaDataArray from UredniDeskaData
 * @phpstan-import-type KategorieUredniDeskyDataArray from KategorieUredniDeskyData
 * @phpstan-import-type KalendarAkciDataArray from KalendarAkciData
 * @phpstan-import-type KategorieKalendareDataArray from KategorieKalendareData
 */
readonly final class StrapiContent
{
    public function __construct(
        private StrapiApiClient $strapiClient,
        private ClockInterface $clock,
    ) {}

    /**
     * @return array<string, SekceData>
     */
    public function getSectionSlugs(): array
    {
        /** @var array{data: array<SekceDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('sekces', populateLevel: 2);

        $data = [];

        foreach ($strapiResponse['data'] as $sekceData) {
            $data[$sekceData['slug']] = SekceData::createFromStrapiResponseWithoutComponents($sekceData);
        }

        return $data;
    }

    /**
     * @param null|string|array<string> $tag
     * @return array<AktualitaData>
     */
    public function getAktualityData(int|null $limit = null, null|array|string $tag = null): array
    {
        $pagination = null;

        if ($limit !== null) {
            $pagination = [
                'limit' => $limit,
                'start' => 0,
            ];
        }

        $filters = [
            'Zobrazovat' => ['$eq' => true],

        ];

        if (is_string($tag)) {
           $filters['tags'] = ['slug' => ['$eq' => $tag]];
        }

        if (is_array($tag)) {
            foreach ($tag as $tagName) {
                $filters['tags']['slug']['$in'][] = $tagName;
            }
        }

        /** @var array{data: array<AktualitaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('aktualities',
            filters: $filters,
            pagination: $pagination,
            sort: [
                'Datum_zverejneni:desc'
            ]);

        return AktualitaData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getAktualitaData(string $slug): AktualitaData
    {
        /** @var array{data: array<AktualitaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('aktualities',
            filters: [
                'Zobrazovat' => ['$eq' => true],
                'slug' => ['$eq' => $slug]
            ]);

        return AktualitaData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    /**
     * @param string|array<string>|null $category
     * @return array<UredniDeskaData>
     */
    public function getUredniDeskyData(
        string|array|null $category = null,
        int|null $limit = null,
        int|null $year = null,
        bool $shouldHideIfExpired = false
    ): array {
        $now = $this->clock->now();
        $filters = [];

        if ($shouldHideIfExpired === true) {
            $filters = [
                'Zobrazovat' => ['$eq' => true],
                '$or' => [
                    ['Datum_stazeni' => ['$null' => true]],
                    ['Datum_stazeni' => ['$gte' => $now->format('Y-m-d')]],
                ],
            ];
        }

        if (is_string($category)) {
            $filters['categories'] = ['slug' => ['$eq' => $category]];
        }

        if (is_array($category)) {
            foreach ($category as $categoryName) {
                $filters['categories']['slug']['$in'][] = $categoryName;
            }
        }

        $pagination = null;

        if ($limit !== null) {
            $pagination = [
                'limit' => $limit,
                'start' => 0,
            ];
        }

        /** @var array{data: array<UredniDeskaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas',
            filters: $filters,
            pagination: $pagination,
            sort: ['Datum_zverejneni:desc', 'Nadpis'],
        );

        return UredniDeskaData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getUredniDeskaData(string $slug): UredniDeskaData
    {
        /** @var array{data: array<UredniDeskaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas',
            filters: [
                'slug' => ['$eq' => $slug],
            ]);

        return UredniDeskaData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    /**
     * @return array<KategorieUredniDeskyData>
     */
    public function getKategorieUredniDesky(): array
    {
        /** @var array{data: array<KategorieUredniDeskyDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('kategorie-uredni-deskies');

        return KategorieUredniDeskyData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<TagData>
     */
    public function getTagy(): array
    {
        /** @var array{data: array<TagDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('tagies', sort: ['rank']);

        return TagData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<MenuData>
     */
    public function getMenu(): array
    {
        /** @var array{data: array<MenuDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('menus', sort: ['Poradi']);

        return MenuData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getSekceData(string $slug): SekceData
    {
        /** @var array{data: array<SekceDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('sekces',
            populateLevel: 8,
            filters: [
            'slug' => ['$eq' => $slug]
        ]);

        return SekceData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    public function getHomepageData(): HomepageData
    {
        /** @var array{data: HomepageDataArray} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('homepage',
            populateLevel: 5,
        );

        return HomepageData::createFromStrapiResponse(
            $strapiResponse['data']
        );
    }

    public function getFooterData(): FooterData
    {
        /** @var array{data: FooterDataArray} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('footer',
            populateLevel: 5,
        );

        return FooterData::createFromStrapiResponse(
            $strapiResponse['data']
        );
    }

    /**
     * @return array<KalendarAkciData>
     */
    public function getKalendarAkciData(): array
    {
        /** @var array{data: array<KalendarAkciDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('kalendar-akcis',
            populateLevel: 5,
        );

        return KalendarAkciData::createManyFromStrapiResponse(
            $strapiResponse['data']
        );
    }

    /**
     * @param string|array<string> $category
     * @return array<KalendarAkciData>
     */
    public function getKalendarAkciForCategoriesData(string|array $category, null|int $limit): array
    {
        $filters = [];

        if (is_string($category)) {
            $filters['Kategorie'] = ['slug' => ['$eq' => $category]];
        }

        if (is_array($category)) {
            foreach ($category as $categoryName) {
                $filters['Kategorie']['slug']['$in'][] = $categoryName;
            }
        }

        $pagination = null;

        if ($limit !== null) {
            $pagination = [
                'limit' => $limit,
                'start' => 0,
            ];
        }

        if ($filters === []) {
            $filters = null;
        }

        /** @var array{data: array<KalendarAkciDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('kalendar-akcis',
            populateLevel: 5,
            filters: $filters,
            pagination: $pagination,
        );

        return KalendarAkciData::createManyFromStrapiResponse(
            $strapiResponse['data']
        );
    }

    /**
     * @return array<ProjektData>
     */
    public function getProjektyData(
        string $sortBy,
        null|string $kategorieFilter,
        null|string $operacniProgramFilter,
        null|string $obecFilter,
    ): array
    {
        if ($sortBy === 'Nejoblíbenější') {
            // TODO: Implement sorting by popularity
        } elseif ($sortBy === 'Nejnovější') {
            // TODO: Implement sorting by newest
        } elseif ($sortBy === 'Nejstarší') {
            // TODO: Implement sorting by oldest
        } elseif ($sortBy === 'Nejdražší') {
            // TODO: Implement sorting by highest price
        } elseif ($sortBy === 'Nejlevnější') {
            // TODO: Implement sorting by lowest price
        } else {
            // TODO: without sorting
        }

        /** @var array{data: array<ProjektDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekties', populateLevel: 6);

        return ProjektData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getProjektData(string $slug): ProjektData
    {
        /** @var array{data: array<ProjektDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekties',
            filters: [
                'slug' => ['$eq' => $slug]
            ]);

        return ProjektData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    /**
     * @return array<ProjektyObecData>
     */
    public function getProjektyObce(): array
    {
        /** @var array{data: array<ProjektyObecDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekty-obecs');

        return ProjektyObecData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<ProjektyKategorieData>
     */
    public function getProjektyKategorie(): array
    {
        /** @var array{data: array<ProjektyKategorieDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekty-kategories');

        return ProjektyKategorieData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<VyzvyOperacniProgramData>
     */
    public function getVyzvyOperacniProgramy(): array
    {
        /** @var array{data: array<VyzvyOperacniProgramDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekty-operacni-programs');

        return VyzvyOperacniProgramData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<VyzvaData>
     */
    public function getVyzvy(): array
    {
        /** @var array{data: array<VyzvaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('vyzvies', populateLevel: 6);

        return VyzvaData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getVyzva(string $slug): VyzvaData
    {
        /** @var array{data: array<VyzvaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('vyzvies',
            populateLevel: 5,
            filters: [
                'slug' => ['$eq' => $slug]
            ]);

        return VyzvaData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound,
        );
    }

    public function getProjekt(string $slug): ProjektData
    {
        /** @var array{data: array<ProjektDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('projekties',
            populateLevel: 6,
            filters: [
                'slug' => ['$eq' => $slug]
            ]);

        return ProjektData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound,
        );
    }
}
