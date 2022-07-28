<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseDepart',TextType::class,['attr'=> ['class' =>'form-control']])
            ->add('adresseArrivee',TextType::class,['attr'=> ['class' =>'form-control']])
            ->add('prixProposee',TextType::class,['attr'=> ['class' =>'form-control']])
            ->add('dateProposee')
            ->add(
                $builder->create('Colis',FormType::class, ['by_reference'=> true])
                    ->add('imageColis')
                    ->add('objetColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('descriptionColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('quantiteColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('largeurColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('longeurColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('hauteurColis',TextType::class,['attr'=> ['class' =>'form-control']])
                    ->add('poidsUnitaireColis',TextType::class,['attr'=> ['class' =>'form-control']])


                    )

            ->getForm()

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
