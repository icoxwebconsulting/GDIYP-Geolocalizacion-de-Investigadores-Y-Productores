<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ProductiveUndertaking;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductiveUndertakingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            )
            ->add(
                'category',
                'entity',
                array(
                    'class' => 'AppBundle:ProductionCategory',
                    'choice_label' => 'name',
                    'attr' => array(
                        "class" => "form-control"
                    )
                )
            )
            ->add(
                'type',
                'entity',
                array(
                    'class' => 'AppBundle:ProductionType',
                    'choice_label' => 'name',
                    'attr' => array(
                        "class" => "form-control"
                    )
                )
            )
            ->add(
                'productionDestination',
                'entity',
                array(
                    'class' => 'AppBundle:ProductionDestinationType',
                    'choice_label' => 'name',
                    'attr' => array(
                        "class" => "form-control"
                    ),
                    'required' => false
                )
            )
            ->add('whereTheySell', 'choice', array(
                'choices' => array(
                        'by_order' => 'Door to door by order',
                        'fairs' => 'Fairs',
                        'markets' => 'Markets',
                        ),
                'required' => false
                )
            )
            ->add('productiveSurface', 'choice', array(
                'choices' => array(
                        'drapery_runners' => 'Drapery Runners',
                        'curtains' => 'Curtains',
                        'bordures' => 'Bordures',
                        ),
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
            'data_class' => 'AppBundle\Entity\ProductiveUndertaking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productive_undertaking';
    }
}