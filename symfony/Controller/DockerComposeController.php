<?php
declare(strict_types=1);

namespace App\Controller;

use App\BuildSymfony;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DockerComposeController extends AbstractController
{
    /** @var BuildSymfony */
    private $builder;

    /**
     * DockerComposeController constructor.
     * @param BuildSymfony $builder
     */
    public function __construct(BuildSymfony $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @Route("/", name="docker-compose-index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('php-version', ChoiceType::class, ['choices' => ['5.x' => '5-fpm', '7.x' => '7-fpm']])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yaml = $this->builder->getComposeYaml($form->getData()['php-version']);
            $response = new Response($yaml);
            $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'docker-compose.yml');
            $response->headers->set('Content-Disposition', $dispositionHeader);


            return $response;
        }

        return $this->render('docker_compose/index.html.twig', ['form' => $form->createView()]);
    }
}