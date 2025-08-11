<?php

declare(strict_types=1);

namespace MASFB\Web\Value\Content\Data;

/**
 * @phpstan-type SekceDataArray array{
 *      id: int,
 *      Nazev: string,
 *      slug: string,
 *      Meta_description: string,
 *      Umisteni_panelu: string,
 *      Komponenty: array<array{__component: string}>,
 *      bocni_panel: array<array{__component: string}>,
 *      parent: null|array{slug: string},
 *  }
 */
readonly final class SekceData
{
    /**
     * @param array<Component> $Komponenty
     * @param array<Component> $Komponenty_panel
     */
    public function __construct(
        public string $Nazev,
        public string $slug,
        public string|null $Meta_description,
        public array $Komponenty,
        public array $Komponenty_panel,
        public string $Umisteni_panelu,
        public null|string $parentSlug,
    ) {
    }

    /**
     * @param SekceDataArray $data
     */
    public static function createFromStrapiResponseWithoutComponents(array $data): self
    {
        return new self(
            $data['Nazev'],
            $data['slug'],
            $data['Meta_description'],
            [],
            [],
            '',
            $data['parent']['slug'] ?? null,
        );
    }

    /**
     * @param SekceDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $components = [];
        $componentsPanel = [];

        foreach ($data['Komponenty'] as $componentInfo) {
            $component = self::createComponent($componentInfo);

            if ($component === null) {
                continue;
            }

            $components[] = $component;
        }

        foreach ($data['bocni_panel'] as $componentInfo) {
            $component = self::createComponent($componentInfo);

            if ($component === null) {
                continue;
            }

            $componentsPanel[] = $component;
        }

        return new self(
            Nazev: $data['Nazev'],
            slug: $data['slug'],
            Meta_description: $data['Meta_description'],
            Komponenty: $components,
            Komponenty_panel: $componentsPanel,
            Umisteni_panelu: $data['Umisteni_panelu'],
            parentSlug: null,
        );
    }

    /**
     * @param array{__component: string} $componentInfo
     */
    public static function createComponent(array $componentInfo): null|Component
    {
        $componentName = $componentInfo['__component'];

        return match ($componentName) {
            'komponenty.nadpis' => new Component('Nadpis', NadpisComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.textove-pole' => new Component('TextovePole', TextovePoleComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.aktuality' => new Component('Aktuality', AktualityComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.formular' => new Component('Formular', FormularComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.galerie' => new Component('Galerie', GalerieComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.obrazek' => new Component('Obrazek', ObrazekComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.rozdelovnik' => new Component('Rozdelovnik', RozdelovnikComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.samosprava' => new Component('Samosprava', SamospravaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.sekce-s-dlazdicema' => new Component('SekceSDlazdicema', SekceSDlazdicemaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.soubory-ke-stazeni' => new Component('SouboryKeStazeni', SouboryKeStazeniComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.tlacitka' => new Component('Tlacitka', TlacitkaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.uredni-deska' => new Component('UredniDeska', UredniDeskaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.terminy-akci' => new Component('TerminyAkci', TerminyAkciComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.vizitky' => new Component('Vizitky', VizitkyComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.karty' => new Component('Karty', KartyComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.program-kina' => new Component('ProgramKina', ProgramKinaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.pas-s-obrazkem' => new Component('PasSObrazkem', PasSObrazkemComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.pas-karet-s-argumenty' => new Component('PasKaretSArgumenty', PasKaretSArgumentyComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.tipy-na-vylet' => new Component('TipyNaVylet', TipyNaVyletComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.bakalari' => new Component('Bakalari', BakalariComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.filtr-tagu' => new Component('KategorieAktualit', KategorieAktualitComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.alert' => new Component('Alert', AlertComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.mapa' => new Component('Mapa', MapaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.faq' => new Component('Faq', FaqComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.organizace-skolniho-roku' => new Component('OrganizaceSkolnihoRoku', OrganizaceSkolnihoRokuComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.tabulka' => new Component('Tabulka', TabulkaComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.historie' => new Component('Historie', HistorieComponentData::createFromStrapiResponse($componentInfo)),
            'komponenty.bocni-panel' => new Component('BocniPanel', BocniPanelComponentData::createFromStrapiResponse($componentInfo)),
            default => null,
        };
    }
}
