<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Profile;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
            ])
            ->add('title', TextType::class, [
                'label' => 'Título',
            ])
            ->add('developer', CheckboxType::class, [
                'label' => 'Soy programador',
                'required' => false,
            ])
            ->add('hr', CheckboxType::class, [
                'label' => 'Soy de recursos humanos',
                'required' => false,
            ])
            ->add('skills', EntityType::class, [
                'label' => false,
                'class' => Skill::class,
                'multiple' => true,
                'expanded' => true,
                'group_by' => function (Skill $choice, $key, $value) {
                    return (string) $choice->getSkillGroup();
                },
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
