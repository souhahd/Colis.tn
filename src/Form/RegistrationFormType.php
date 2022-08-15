<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['attr'=> ['class' =>'form-control','placeholder' => 'Email'],'label' => false])
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

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'label'=>false,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field','label'=>false]],
                'required' => true,
                'first_options'  => ['attr'=> ['class' =>'form-control','placeholder' => 'Mot de passe','label'=>false]],
                'second_options' => ['attr'=> ['class' =>'form-control','placeholder' => 'Confirmation mot de passe','label'=>false]],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','class' =>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])


            ->add('image',FileType::class, [
            "required" => true ,
            'attr'=> ['class' =>'form-control'],'label' => false
        ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
