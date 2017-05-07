<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ContactMean;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactMeanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'lastName',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'phone',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'cell_phone',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'email',
                EmailType::class, array(
                    'required' => false
                )
            )
            ->add(
                'facebook',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'website',
                TextType::class, array(
                    'required' => false
                )
            )
            ->add(
                'comment',
                TextType::class, array(
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
            'data_class' => 'AppBundle\Entity\ContactMean'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contact_mean';
    }
}