<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\InstitutionalProject;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InstitutionalProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                        'public_policy' => 'Public Policy',
                        'state_financing' => 'State Financing',
                        'private_financing' => 'Private Financing',
                        'other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true
                )
            )
            ->add(
                'population',
                TextType::class
            )
            ->add(
                'duration',
                TextType::class
            )
            ->add(
                'articulations',
                TextType::class
            )
            ->add(
                'comment',
                TextareaType::class
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\InstitutionalProject'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'institutional_project';
    }
}