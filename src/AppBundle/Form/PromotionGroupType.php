<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\PromotionGroup;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PromotionGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                        'Guild Syndicate' => 'Guild Syndicate',
                        'Political Social Organization' => 'Political Social Organization',
                        'Study Groups' => 'Study Groups',
                        'Professional Intervention Group' => 'Professional Intervention Group',
                        'Nongovernmental Organization' => 'Nongovernmental Organization',
                        'Corporate Group' => 'Corporate Group',
                        'Marketers Productors Group' => 'Marketers Productors Group',
                        'Other' => 'Other',
                        
                    ),
                'multiple' => true,
                'expanded' => true,
                'required' => false
                )
            )
            ->add(
                'modality',
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
            'data_class' => 'AppBundle\Entity\PromotionGroup'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'promotion_group';
    }
}