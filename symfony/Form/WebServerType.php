<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class WebServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'webserver',
            ChoiceType::class,
            [
                'choices' => ['Nginx' => 'nginx', 'Apache' => 'apache'],
                'expanded' => true
            ]
        );
    }
}
