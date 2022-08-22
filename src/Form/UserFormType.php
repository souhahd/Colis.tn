<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,['attr'=> ['class' =>'form-control','placeholder' => 'Nom'],'label' => false])
            ->add('prenom',TextType::class,['attr'=> ['class' =>'form-control','placeholder' => 'Prenom'],'label' => false])
            ->add('genre',ChoiceType::class, array(
                'choices' => array(
                    'Homme'=>'Homme',
                    'Femme'=>'Femme',
                    'Autre'=> 'Autre',
                ),'label' => false
            ))
            ->add('dateNaissance',DateType::class,['widget' => 'single_text','label' => false])
            ->add('adresse',TextType::class,['attr'=> ['class' =>'form-control','placeholder' => 'Adresse'],'label' => false])
            ->add('telephone',TextType::class,['attr'=> ['class' =>'form-control','placeholder' => 'Telephone'],'label' => false])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
