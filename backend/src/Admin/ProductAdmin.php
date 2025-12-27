<?php

declare(strict_types=1);

namespace App\Admin;

use App\Form\ProductImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class ProductAdmin extends AbstractAdmin
{
    protected function configure(): void
    {
        $this->setTranslationDomain('admin');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id', null, [
                'label' => 'product.field.id',
            ])
            ->add('name', null, [
                'label' => 'product.field.name',
            ])
            ->add('category', null, [
                'label' => 'product.field.category',
            ])
            ->add('price', null, [
                'label' => 'product.field.price',
            ])
            ->add('quantity', null, [
                'label' => 'product.field.quantity',
            ])
            ->add('publicId', null, [
                'label' => 'product.field.publicId',
            ])
            ->add('createdAt', null, [
                'label' => 'product.field.createdAt',
            ])
            ->add('updatedAt', null, [
                'label' => 'product.field.updatedAt',
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id', null, [
                'label' => 'product.field.id',
            ])
            ->add('name', null, [
                'label' => 'product.field.name',
            ])
            ->add('category', null, [
                'label' => 'product.field.category',
            ])
            ->add('price', null, [
                'label' => 'product.field.price',
            ])
            ->add('inStock', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'product.field.in_stock',
            ])
            ->add('quantity', null, [
                'label' => 'product.field.quantity',
            ])
            ->add('publicId', null, [
                'label' => 'product.field.public_id',
            ])
            ->add('createdAt', null, [
                'label' => 'product.field.created_at',
            ])
            ->add('updatedAt', null, [
                'label' => 'product.field.updated_at',
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label' => 'product.field.actions',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', null, [
                'label' => 'product.field.name',
            ])
            ->add('category', null, [
                'label' => 'product.field.category',
            ])
            ->add('price', NumberType::class, [
                'label' => 'product.field.price',
                'scale' => 2,
                'html5' => true,
                'required' => true,
            ])
            ->add('quantity', null, [
                'label' => 'product.field.quantity',
            ])
            ->add('publicId', null, [
                'label' => 'product.public_id',
                'disabled' => true,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ProductImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id', null, [
                'label' => 'product.field.id',
            ])
            ->add('name', null, [
                'label' => 'product.field.name',
            ])
            ->add('category', null, [
                'label' => 'product.field.category',
            ])
            ->add('price', null, [
                'label' => 'product.field.price',
            ])
            ->add('inStock', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'product.field.inStock',
            ])
            ->add('quantity', null, [
                'label' => 'product.field.quantity',
            ])
            ->add('publicId', null, [
                'label' => 'product.field.publicId',
            ])
            ->add('createdAt', null, [
                'label' => 'product.field.createdAt',
            ])
            ->add('updatedAt', null, [
                'label' => 'product.field.updatedAt',
            ])
            ->add('images', null, [
                'label' => 'product.field.images',
                'template' => 'admin/product/show_images.html.twig',
            ])
        ;
    }
}
