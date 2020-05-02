<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPreferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'required' => true,
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'readonly' => true,
                ]
            ])
            ->add('mobile', TextType::class, [
                'label' => 'Mobile',
                'required' => false,
            ])
            ->add('newsletter', CheckboxType::class, [
                'required' => false,
            ])
            /*->add('tshirt_size', TextType::class, [
                'label' => 'Tshirt size',
                'required' => false,
            ])*/
            ->add('country', TextType::class, [
                'label' => 'Páis',
                'required' => false,
            ])
            ->add('salaryExpectation', ChoiceType::class, [
                'label' => 'Expectativa salarial',
                'choices' => [
                    '10,000 a 15,000' => '10_15',
                    '15,000 a 20,000' => '15_20',
                    '20,000 a 25,000' => '20_25',
                    '25,000 a 30,000' => '25_30',
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
                    'Más de 80,000'   => '80_',
                ],
            ])
            ->add('offerts', CheckboxType::class, [
                'label' => 'Estoy abierto a escuchar ofertas',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ciudad',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
