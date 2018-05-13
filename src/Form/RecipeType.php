<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\User;
use App\Entity\Coll;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

// use Symfony\Component\Form\CallbackTransformer;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created' ,
                   DateType::class ,
                   [ 'widget'   => 'single_text' ,
                    'html5'     => true ,
                    'disabled'  => true ,
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
            ->add("coll" , null, [
                'label' => 'Collection'
                // 'data_class' => 'App\Entity\Coll'
            ] ) 
            ->add('title')
            ->add('summary')
            ->add('steps' , TextareaType::class , [
                'attr'  => ['rows'      => 10 , 'cols' => 50 ]
            ])
            ->add('ingredients' , TextareaType::class , [
                'attr'  => ['rows'      => 10 , 'cols' => 50 ]
            ])
            ->add('isPublic')
            ->add('isShared')
        ;

        // $builder->get("user")->addModelTransformer(new CallbackTransformer(
        //         function ($user) {
        //             // transform the array to a string
        //             return $user->getUserName();
        //         },
        //         function ($user) {
        //             // transform the array to a string
        //             return $user->getUserName();
        //         }

        //     ));        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
