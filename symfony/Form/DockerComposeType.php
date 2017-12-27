<?php
declare(strict_types=1);

namespace App\Form;

use App\SymfonyBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class DockerComposeType extends AbstractType
{
    /** @var SymfonyBuilder */
    private $symfonyBuilder;

    /**
     * DockerComposeType constructor.
     * @param SymfonyBuilder $symfonyBuilder
     */
    public function __construct(SymfonyBuilder $symfonyBuilder)
    {
        $this->symfonyBuilder = $symfonyBuilder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->symfonyBuilder->getSupportedServices() as $name => $service) {
            if (count($service) === 1) {
                $builder->add(
                    $name,
                    ChoiceType::class,
                    [
                        'choices' => $service['versions'],
                        'expanded' => true,
                        'data' => reset($service['versions'])
                    ]
                );
            }
        }
    }
}
