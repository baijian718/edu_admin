<?php

namespace App\Admin\Controllers;

use App\Model\StStudent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StStudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'StStudent';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StStudent());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('st_sn', __('Sn'));
        $grid->column('created_at', __('CreatedAt'));
        $grid->column('updated_at', __('UpdatedAt'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(StStudent::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('st_sn', __('Sn'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new StStudent());

        $form->text('name', __('Name'));
        $form->text('st_sn', __('Sn'));

        return $form;
    }
}
