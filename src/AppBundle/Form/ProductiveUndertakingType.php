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
                TextType::class
            )
            ->add(
                'comment',
                TextareaType::class
            )
            ->add(
                'productionDestination',
                'entity',
                array(
                    'class' => 'AppBundle:ProductionDestinationType',
                    'choice_label' => 'name',
                    'attr' => array(
                        "class" => "form-control"
                    )
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
    public function getName()
    {
        return 'productive_undertaking';
    }
}