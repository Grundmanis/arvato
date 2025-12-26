<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class ProductAdmin extends AbstractAdmin
{
    protected function configure(): void
    {
        $this->setTranslationDomain('admin');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        // $filter
        //     ->add('id')
        //     ->add('name')
        //     ->add('category')
        //     ->add('price')
        //     ->add('quantity')
        //     ->add('publicId')
        //     ->add('createdAt')
        //     ->add('updatedAt')
        $filter
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
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);

        // $list
        //     ->add('id')
        //     ->add('name')
        //     ->add('category')
        //     ->add('price')
        //     ->add('inStock', FieldDescriptionInterface::TYPE_BOOLEAN, [
        //         'label' => 'In stock',
        //     ])
        //     ->add('quantity')
        //     ->add('publicId')
        //     ->add('createdAt')
        //     ->add('updatedAt')

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
            ->add('price', null, [
                'label' => 'product.field.price',
            ])
            ->add('quantity', null, [
                'label' => 'product.field.quantity',
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => FileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ]);
        // ->add('name')
        // ->add('category')
        // ->add('price', NumberType::class, [
        //     'label' => 'Price',
        //     'scale' => 2,
        //     'html5' => true,
        //     'required' => true,
        // ])
        // ->add('quantity')
        // ->add('publicId', null, [
        //     'label' => 'product.public_id',
        //     'disabled' => true,
        // ])
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('category')
            ->add('price')
            ->add('inStock', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'In stock',
            ])
            ->add('quantity')
            ->add('publicId')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
