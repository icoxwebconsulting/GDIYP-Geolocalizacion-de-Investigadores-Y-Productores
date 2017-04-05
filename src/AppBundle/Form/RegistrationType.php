<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class
            )
            ->add(
                'lastName',
                TextType::class
            )
            ->add(
                'image',
                VichImageType::class,
                array(
                    'label' => false,
                    'required' => false
                )
            )
            ->add(
                'email',
                EmailType::class
            )
            ->add('roles', 'choice',
                array(
                    'mapped' => false,
                    'required' => true,
                    'label'    => 'User Type',
                    'choices' => array(
                        'ROLE_INVESTIGATOR' => 'Investigator',
                        'ROLE_PRODUCER' => 'Producer',
                        ),
                    'expanded'   => true,
                    'multiple' => false
                )
            )
            ->add('plainPassword', RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                )
            );
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}