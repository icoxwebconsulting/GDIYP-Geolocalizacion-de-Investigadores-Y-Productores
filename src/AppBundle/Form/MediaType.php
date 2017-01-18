<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Media;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class
            )
            ->add(
                'file',
                VichFileType::class,
                array(
                    'label' => false,
                    'required' => false
                )
            )
            ->add(
                'type',
                EntityType::class,
                array(
                    'class' => 'AppBundle:MediaType',
                    'choice_label' => 'name',
                    'attr' => array(
                        "class" => "form-control"
                    )
                )
            )
            ->add(
                'news',
                EntityType::class,
                array(
                    'class' => 'AppBundle:News',
                    'choice_label' => 'title',
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
            'data_class' => 'AppBundle\Entity\Media'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_media';
    }
}