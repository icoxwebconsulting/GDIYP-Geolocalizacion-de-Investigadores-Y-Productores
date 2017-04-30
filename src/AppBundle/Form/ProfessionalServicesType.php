<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ProfessionalServices;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfessionalServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                        'advisory' => 'Advisory',
                        'training' => 'Training',
                        'purchase_and_marketing' => 'Purchase and Marketing',
                        'supplies_and_machinery_sale' => 'Supplies and Machinery Sales',
                        'other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true,
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
            'data_class' => 'AppBundle\Entity\ProfessionalServices'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'professional_services';
    }
}