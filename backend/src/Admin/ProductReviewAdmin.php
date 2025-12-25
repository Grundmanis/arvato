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
            ->add('id')
            ->add('rating')
            ->add('comment')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('product', null, [
                'label' => 'Product',
                'associated_property' => 'name',
                'sortable' => true,
                'route' => [
                    'name' => 'edit',
                    'parameters' => ['id' => 'id'],
                ],
            ])
            ->add('rating')
            ->add('comment')
            ->add('createdAt')
            ->add('updatedAt')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $isEdit = $this->getSubject() && $this->getSubject()->getId();
        $form
            ->add('product', ModelType::class, [
                'label' => 'product_review.product',
                'property' => 'name',
                'disabled' => $isEdit,
            ])
            ->add('rating')
            ->add('comment')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('product', null, [
                'label' => 'Product',
                'associated_property' => 'name',
                'sortable' => true,
                'route' => [
                    'name' => 'edit',
                    'parameters' => ['id' => 'id'],
                ],
            ])
            ->add('rating')
            ->add('comment')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
