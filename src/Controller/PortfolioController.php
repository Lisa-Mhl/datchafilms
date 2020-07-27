<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Entity\Video;
use App\Repository\PortfolioRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends AbstractController
{

    /* INJECTION DE DEPENDANCE*/
    private $portfolioRepo;

    public function __construct(PortfolioRepository $portfolioRepo)
    {
        $this->portfolioRepo = $portfolioRepo;
    }


    /**
     * @Route("/", name="portfolio")
     */
    public function home()
    {
        $portfolios = $this->getDoctrine()->getRepository(Portfolio::class)->findAll();
        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolios,
        ]);
    }

    /**
     * @Route("/portfolio/{title}", name="one_portfolio")
     */
    public function showPortfolio(Portfolio $portfolio)
    {
        $portfolios = $this->getDoctrine()->getRepository(Portfolio::class)->findAll();
        return $this->render('portfolio/one_portfolio.html.twig', [
            'portfolio' => $this->portfolioRepo->find($portfolio),
            'videos' => $this->portfolioRepo->find($portfolio)->getVideos(),
            'portfolios' => $portfolios,
        ]);
    }

    /**
     * @Route("/player/{id}", name="player")
     * @param Video $video
     * @return Response
     */
    public function player(VideoRepository $videoRepository,Video $video): Response
    {
        $videos = $videoRepository->findAll();
        return $this->render('portfolio/player.html.twig', [
            'video' => $video,
            'videos' => $videos,
        ]);
    }
}
