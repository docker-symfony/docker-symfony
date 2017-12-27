<?php
declare(strict_types=1);

namespace App\Controller;

use App\SymfonyBuilder;
use App\Form\DockerComposeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DockerComposeController extends AbstractController
{
    /** @var SymfonyBuilder */
    private $builder;

    /**
     * DockerComposeController constructor.
     * @param SymfonyBuilder $builder
     */
    public function __construct(SymfonyBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @Route("/", name="docker-compose-form")
     * @param Request $request
     * @return Response
     */
    public function indexForm(Request $request): Response
    {
        $form = $this->createForm(DockerComposeType::class);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData() as $service => $version) {
                $this->builder->addService($service, $version);
            }
            return $this->zipResponse();
        }
        return $this->render(
            'docker_compose/form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @return Response
     */
    private function zipResponse(): Response
    {
        $zip = new \ZipArchive();
        $filename = sprintf('/tmp/%s.zip', uniqid());
        $zip->open($filename, \ZipArchive::CREATE);
        foreach ($this->builder->build() as $path => $content) {
            $zip->addFromString($path, $content);
        }
        $zip->close();

        return $this->downloadResponse('deploy.zip', file_get_contents($filename));
    }

    /**
     * @param $filename
     * @return Response
     */
    private function downloadResponse($filename, $content): Response
    {
        $response = new Response($content);
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}