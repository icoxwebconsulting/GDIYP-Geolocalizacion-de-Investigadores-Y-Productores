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
                'expanded' => true,
                'required' => false
                )
            )
            ->add(
                'population',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'duration',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'articulations',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'comment',
                TextareaType::class, array(
                    'required' => false
                )
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
    public function getBlockPrefix()
    {
        return 'institutional_project';
    }
}