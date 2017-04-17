<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\AgroecologicalPractice;

class AgroecologicalPracticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'practiceName',
                TextType::class
            )
            ->add(
                'organizationName',
                TextType::class
            )
            ->add(
                'description',
                TextareaType::class
            )
            ->add(
                'graphicInformation',
                TextareaType::class
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AgroecologicalPractice'
        ));

    }
    
    public function getBlockPrefix()
    {
        return 'appbundle_agroecologialpractice';
    }
}