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
                        'guild_syndicate' => 'Guild / Syndicate',
                        'political_social_organization' => 'Political Social Organization',
                        'study_groups' => 'Study Groups',
                        'professional_intervention_group' => 'Professional Intervention Group',
                        'nongovernmental_organization' => 'Nongovernmental Organization',
                        'corporate_group' => 'Corporate Group',
                        'marketers_productors_group' => 'Marketers / Productors Group',
                        'other' => 'Other',
                        
                    ),
                'multiple' => true,
                'expanded' => true
                )
            )
            ->add(
                'modality',
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
            'data_class' => 'AppBundle\Entity\PromotionGroup'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'promotion_group';
    }
}