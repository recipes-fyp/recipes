<?php

namespace App\Form;

use App\Entity\Coll;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created' ,
                   DateType::class , [ 
                    'widget'   => 'single_text' ,
                    'disabled'  => true ,
                    'html5'     => true ,
                    'data'      => new \DateTime(),
                    'format'    => "yy-MM-dd HH:mm:ss",
                    'attr'      => ['readonly'      => true ]
               ] 
            )        
            ->add('user' , null , [ 
                    'disabled'  => true ,
                    'attr'      => ['readonly'      => true ]
                    ] 
            )
            ->add('title')
            ->add('isShared')
            ->add('isPublic')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coll::class,
        ]);
    }
}
