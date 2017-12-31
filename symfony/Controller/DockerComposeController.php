<?php
declare(strict_types = 1);

namespace App\Controller;

use App\ApplicationDefinition;
use DockerSymfony\Builder\ApplicationBuilder;
use DockerSymfony\ComposeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DockerComposeController extends AbstractController
{
    /** @var ApplicationBuilder */
    private $builder;
    /** @var ApplicationDefinition */
    private $definition;

    public function __construct(ApplicationBuilder $builder, ApplicationDefinition $definition)
    {
        $this->builder = $builder;
        $this->definition = $definition;
    }

    /**
     * @Route("/", name="docker-compose-form", methods={"get"})
     */
    public function showForm(): Response
    {
        return $this->render(
            'docker_compose/form.html.twig',
            ['application' => $this->definition]
        );
    }

    /**
     * @Route("/", name="docker-compose-form-post", methods={"post"})
     */
    public function handleForm(Request $request): Response
    {
        foreach ($request->get('services') as $category => $services) {
            $service = $services[$services['selected']];
            $this->builder->addService(new ComposeService($service['name'], $service['version']));
        }
        return $this->zipResponse();
    }


    private function zipResponse(): Response
    {
        $zip = new \ZipArchive();
        $filename = sprintf('/tmp/%s.zip', uniqid());
        $zip->open($filename, \ZipArchive::CREATE);
        foreach ($this->builder->generateFiles() as $path => $content) {
            $zip->addFromString($path, $content);
        }
        $zip->close();

        return $this->downloadResponse('deploy.zip', file_get_contents($filename));
    }

    private function downloadResponse($filename, $content): Response
    {
        $response = new Response($content);
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}
