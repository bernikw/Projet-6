<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;


class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Insérer l\'URL de la vidéo',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '#^((?:https?:)?\/\/)?(?:www\.)?((?:youtube\.com|youtu\.be|dai\.ly|dailymotion\.com|vimeo\.com|player\.vimeo\.com))(\/(?:[\w\-]+\?v=|embed\/|video\/|embed\/video\/)?)([\w\-]+)(\S+)?$#',
                        'message' => 'Tu peux télécharger youtube, dailymotion ou vimeo video url',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
