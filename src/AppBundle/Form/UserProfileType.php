<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'job_title',
                TextType::class
            )
            ->add(
                'address',
                TextareaType::class,
                array(
                    'label' => false,
                    'mapped' => true,
                    'attr' => array(
                        "minlength" => 1, //Longitud minima
                        "placeholder" => "Address"
                    )
                )
            )
            ->add(
                'summary',
                TextareaType::class,
                array(
                    'label' => false,
                    'mapped' => true,
                    'attr' => array(
                        "minlength" => 1, //Longitud minima
                        "placeholder" => "Summary"
                    )
                )
            )
            ->add(
                'user',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\User',
                    'choice_label' => 'username',
                )
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserProfile'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_userprofile';
    }


}
