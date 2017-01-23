<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\News;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class
            )
            ->add(
                'subtitle',
                TextType::class,
                array(
                    'required' => false
                )
            )
            ->add(
                'description',
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
                'category',
                EntityType::class,
                array(
                    'class' => 'AppBundle:Category',
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
            'data_class' => 'AppBundle\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_news';
    }
}