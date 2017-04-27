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
                        'wholesale_market' => 'Wholesale Market',
                        'retail_market' => 'Retail Market',
                        ),
                'multiple' => true,
                'expanded' => true
                )
            )
            ->add('type', 'choice', array(
                'choices' => array(
                        'productor_fairs' => 'Productor Fairs',
                        'delivery' => 'Delivery',
                        'home_delivery' => 'Home Delivery',
                        'online_sale' => 'Online Sale',
                        'other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true
                )
            )
            ->add('periodicity', 'choice', array(
                'choices' => array(
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'fortnightly' => 'Fortnightly',
                        'monthly' => 'Monthly',
                        'sixmonthly' => 'Six-Monthly',
                        'yearly' => 'Yearly',
                        'other' => 'Other',
                        ),
                'multiple' => true,
                'expanded' => true
                )
            )
            ->add(
                'peopleInvolved',
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
            'data_class' => 'AppBundle\Entity\MarketingSpaces'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'marketing_spaces';
    }
}