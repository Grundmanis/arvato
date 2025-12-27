<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;

final class ProductReviewAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id', null, [
                'label' => 'productReview.field.id',
            ])
            ->add('rating', null, [
                'label' => 'productReview.field.rating',
            ])
            ->add('comment', null, [
                'label' => 'productReview.field.comment',
            ])
            ->add('createdAt', null, [
                'label' => 'productReview.field.created_at',
            ])
            ->add('updatedAt', null, [
                'label' => 'productReview.field.updated_at',
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id', null, [
                'label' => 'productReview.field.id',
            ])
            ->add('product', null, [
                'label' => 'productReview.field.product',
                'associated_property' => 'name',
                'sortable' => true,
                'route' => [
                    'name' => 'edit',
                    'parameters' => ['id' => 'id'],
                ],
            ])
            ->add('rating', null, [
                'label' => 'productReview.field.rating',
            ])
            ->add('comment', null, [
                'label' => 'productReview.field.comment',
            ])
            ->add('createdAt', null, [
                'label' => 'productReview.field.created_at',
            ])
            ->add('updatedAt', null, [
                'label' => 'productReview.field.updated_at',
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label' => 'productReview.field.actions',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $isEdit = null !== $this->getSubject()->getId();

        $form
            ->add('product', ModelType::class, [
                'label' => 'productReview.field.product',
                'property' => 'name',
                'disabled' => $isEdit,
            ])
            ->add('rating', null, [
                'label' => 'productReview.field.rating',
            ])
            ->add('comment', null, [
                'label' => 'productReview.field.comment',
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id', null, [
                'label' => 'productReview.field.id',
            ])
            ->add('product', null, [
                'label' => 'productReview.field.product',
                'associated_property' => 'name',
                'sortable' => true,
                'route' => [
                    'name' => 'edit',
                    'parameters' => ['id' => 'id'],
                ],
            ])
            ->add('rating', null, [
                'label' => 'productReview.field.rating',
            ])
            ->add('comment', null, [
                'label' => 'productReview.field.comment',
            ])
            ->add('createdAt', null, [
                'label' => 'productReview.field.created_at',
            ])
            ->add('updatedAt', null, [
                'label' => 'productReview.field.updated_at',
            ]);
    }
}
