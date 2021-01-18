<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request, EntityManagerInterface $em, YoutubeRepository $videos): Response
    {
        $youtube = new Youtube();
        $form = $this->createForm(YoutubeType::class,$youtube);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($youtube);
            $em->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('youtube/index.html.twig', [
            'form' => $form->createView(),
            'videos' => $videos->findAll()
        ]);
    }

    /**
     * @Route("/video/{id}", name="app_video")
     */
    public function video(Request $request, EntityManagerInterface $em, Youtube $video): Response
    {
        return $this->render('youtube/video.html.twig', [
            'video' => $video
        ]);
    }
}
