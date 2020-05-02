<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Job;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('job', EntityType::class, [
                'label' => false,
                'class' => Job::class,
                'choice_label' => 'title',
                'placeholder' => 'Selecciona una oferta de trabajo',
                'query_builder' => function(EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('j')
                        ->where('j.owner = :owner')
                        ->andWhere('j.active = true')
                        ->setParameter('owner', $user);
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'user' => User::class
        ]);
    }
}
