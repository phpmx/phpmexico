<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\Skill;
use App\Entity\SkillPercent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
