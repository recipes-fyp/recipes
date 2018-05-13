<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created' , 
                    DateType::class ,[ 
                    'widget'   => 'single_text' ,
                    'html5'     => true ,
                    'disabled'  => true ,
                    'data'      => new \DateTime(),
                    'format'    => "yy-MM-dd HH:mm:ss",
                    'attr'      => ['readonly'      => true ]
                    ]
            )

            ->add('recipe' , null , [ 
                    'disabled'     => true ,
                    'attr'      => ['readonly'      => true ]
                    ]
    
            ) 
            ->add('user' , null ,[ 
                    'disabled'  => true ,
                    'attr'      => ['readonly'      => true ]
                    ]
            )
            ->add('comment' ,
                TextareaType::class , [
                'attr'  => ['rows'      => 10 , 'cols'  => 50 ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
