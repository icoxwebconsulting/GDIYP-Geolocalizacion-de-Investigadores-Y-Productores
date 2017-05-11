<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\AgroecologicalPractice;
use AppBundle\Entity\ProductiveUndertaking;
use AppBundle\Entity\MarketingSpaces;
use AppBundle\Entity\ProfessionalServices;
use AppBundle\Entity\InstitutionalProject;
use AppBundle\Entity\PromotionGroup;
use AppBundle\Entity\ContactMean;

class AgroecologicalPracticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contact_mean', new ContactMeanType());
        $builder->add('productive_undertaking', new ProductiveUndertakingType());
        $builder->add('marketing_spaces', new MarketingSpacesType());
        $builder->add('professional_services', new ProfessionalServicesType());
        $builder->add('institutional_project', new InstitutionalProjectsType()); 
        $builder->add('promotion_group', new PromotionGroupType()); 
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
                'country',
                'entity',
                array(
                    'class' => 'AppBundle:Country',
                    'choice_label' => 'name',
                    'empty_value' => 'Select',
                    'attr' => array(
                        "class" => "form-control"
                    )
                )
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
        return 'appbundle_agroecologicalpractice';
    }
}