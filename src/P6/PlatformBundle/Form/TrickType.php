<?php

namespace P6\PlatformBundle\Form;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TrickType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class)
                ->add('description',TextareaType::class)
                ->add('category', EntityType::class, array(
                    'class'        => 'P6PlatformBundle:Category',
                    'choice_label' => 'name',
                    'multiple'     => true,
                ))
                ->add('images', CollectionType::class, array(
                    'entry_type'   => ImageType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype' => true,
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P6\PlatformBundle\Entity\Trick'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p6_platformbundle_trick';
    }


}
