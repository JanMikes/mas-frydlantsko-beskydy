<?php

declare(strict_types=1);

namespace MASFB\Web\Controller;

use MASFB\Web\Services\Strapi\StrapiContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityController extends AbstractController
{
    public function __construct(
        readonly private StrapiContent $content
    ) {}

    #[Route('/aktuality', name: 'aktuality')]
    #[Route('/aktuality/kategorie/{tags}', name: 'aktuality_kategorie')]
    public function __invoke(string|null $tags = null): Response
    {
        // Parse comma-separated tags into array
        $tagsArray = null;
        $activeTags = [];

        if ($tags !== null && $tags !== '') {
            $tagsArray = array_filter(array_map('trim', explode(',', $tags)));
            $activeTags = $tagsArray;
        }

        return $this->render('aktuality.html.twig', [
            'tagy' => $this->content->getTagy(),
            'active_tags' => $activeTags,
            'aktuality' => $this->content->getAktualityData(tag: $tagsArray),
        ]);
    }
}
