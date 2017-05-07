<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\MarketingSpaces;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MarketingSpacesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marketWhereSold', 'choice', array(
                'choices' => array(
                        'Wholesale Market' => 'Wholesale Market',
                        'Retail Market' => 'Retail Market',
                        ),
                'multiple' => true,
                'expanded' => true,
                'required' => false
                )
            )
            ->add('type', 'choice', array(
                'choices' => array(
                        'Productor Fairs' => 'Productor Fairs',
                        'Delivery' => 'Delivery',
                        'Home Delivery' => 'Home Delivery',
                        'Online Sale' => 'Online Sale',
                        'Other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true,
                'required' => false
                )
            )
            ->add('periodicity', 'choice', array(
                'choices' => array(
                        'Daily' => 'Daily',
                        'Weekly' => 'Weekly',
                        'Fortnightly' => 'Fortnightly',
                        'Monthly' => 'Monthly',
                        'Sixmonthly' => 'Six-Monthly',
                        'Yearly' => 'Yearly',
                        'Other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true,
                'required' => false
                )
            )
            ->add(
                'peopleInvolved',
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
            'data_class' => 'AppBundle\Entity\MarketingSpaces'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketing_spaces';
    }
}