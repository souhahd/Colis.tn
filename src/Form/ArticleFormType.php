<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreArticle',TextType::class,[
                'attr'=> ['class' =>'form-control'],
                'label'=>'Titre'])
            ->add('imageFile', VichImageType::class, [
                'label'=>'',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => '...',
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('contenuArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Contenu'])
            ->add('datePubArticle',DateTimeType::class,[
        'label'=>'Date de publication'])
            ->add('auteurArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Auteur'])
            ->add('sourceArticle',TextType::class,['attr'=> ['class' =>'form-control'],
                'label'=>'Source'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
