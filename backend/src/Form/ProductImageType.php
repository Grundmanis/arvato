<?php

namespace App\Form;

use App\Entity\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var ProductImage|null $image */
            $image = $event->getData();
            $form = $event->getForm();

            $help = null;
            if ($image && $image->getPath()) {
                $help = '<img src="'.$image->getUrl().'" style="max-height: 80px;">';
            }

            $form->add('file', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'data_class' => null,
                'help_html' => true,
                'help' => $help,
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
