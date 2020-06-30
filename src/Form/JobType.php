<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Job;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ckedit_config = [
            'attr' => [],
            'config' => [
                'uiColor' => '#ffffff',
                'toolbar' => 'basic',
            ],
        ];

        $builder
            ->add('title', TextType::class, [
                'label' => 'Nombre de la vacante',
                'help' => 'Por ejemplo: Frontend React Developer',
            ])
            ->add('contact', TextType::class, [
                'label' => 'Nombre',
                'attr' => [],
                'help' => 'Nombre de la persona a la que tienen que contactar',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'help' => 'Email para más información de la vacante',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Teléfono',
                'help' => 'Numero de telefono para más información de la vacante',
            ])
            ->add('description', CKEditorType::class, $ckedit_config + [
                'help' => 'Describe las responsabilidades que tendrá la vacante',
            ])
            ->add('requirements', CKEditorType::class, $ckedit_config + [
                'help' => 'Describe los requisitos técnicos que debe cumplir',
            ])
            ->add('application_url', UrlType::class, [
                'label' => 'Link de la vante',
                'help' => 'Link a una publicación previa o a la página de la empresa',
            ])
            ->add('salary', ChoiceType::class, [
                'label' => 'Oferta Salarial',
                'choices' => [
                    'En entrevista' => 'En entrevista',
                    '10,000 a 15,000' => '10,000 a 15,000',
                    '15,000 a 20,000' => '15,000 a 20,000',
                    '20,000 a 25,000' => '20,000 a 25,000',
                    '25,000 a 30,000' => '25,000 a 30,000',
                    '30,000 a 35,000' => '30_35',
                    '35,000 a 40,000' => '35_40',
                    '40,000 a 45,000' => '40_45',
                    '45,000 a 50,000' => '45_50',
                    '50,000 a 55,000' => '50_55',
                    '55,000 a 60,000' => '55_60',
                    '60,000 a 65,000' => '60_65',
                    '65,000 a 70,000' => '65_70',
                    '70,000 a 75,000' => '70_75',
                    '75,000 a 80,000' => '75_80',
                    'Más de 80,000' => '80_',
                ],
            ])
            ->add('company')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
