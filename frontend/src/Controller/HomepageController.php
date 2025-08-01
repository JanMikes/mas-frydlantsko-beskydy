<?php
declare(strict_types=1);

namespace MASFB\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use MASFB\Web\Services\Strapi\StrapiContent;

final class HomepageController extends AbstractController
{
    public function __construct(
        readonly private StrapiContent $content,
    ) {}

    #[Route(path: '/', name: 'homepage')]
    public function __invoke(): Response
    {
        try {
            $section = $this->content->getSekceData('home');
        } catch (ClientException) {
            $section = null;
        }

        try {
            $homepageData = $this->content->getHomepageData();
        } catch (ClientException) {
            $homepageData = null;
        }

        return $this->render('homepage.html.twig', [
            'section' => $section,
            'homepage' => $homepageData,
            'kalendar_akci' => $this->content->getKalendarAkciData(),
        ]);
    }
}
