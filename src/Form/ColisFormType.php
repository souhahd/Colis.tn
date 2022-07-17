<?php

namespace App\Form;

use App\Entity\Colis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objetColis')
            ->add('quantiteColis')
            ->add('largeurColis')
            ->add('longeurColis')
            ->add('hauteurColis')
            ->add('poidsUnitaireColis')
            ->add('idAnnonce')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Colis::class,
        ]);
    }
}
