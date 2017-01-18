<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'first_name',
                TextType::class
            )
            ->add(
                'last_name',
                TextType::class
            )
            ->add(
                'image',
                VichImageType::class,
                array(
                    'label' => false,
                    'data_class' => null,
                    'property_path' => 'image',
                    'required' => false,
                )
            )
            ->add(
                'email',
                EmailType::class
            );
//            ->add('roles', 'choice',
//                array(
//                    'mapped' => false,
//                    'required' => true,
//                    'label'    => 'User Type',
//                    'choices' => array(
//                        'ROLE_INVESTIGATOR' => 'Investigator',
//                        'ROLE_PRODUCER' => 'Producer',
//                    ),
//                    'expanded'   => true,
//                    'multiple' => false
//                )
//            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
