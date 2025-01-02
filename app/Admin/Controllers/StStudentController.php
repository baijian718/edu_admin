<?php

namespace App\Admin\Controllers;

use App\Model\StStudent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class StStudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学生中心';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StStudent());
        $grid->column('id', __('id'))->sortable();
        $grid->column('name', __('姓名'));
        $grid->column('st_sn', __('编号'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('name', '姓名');
            $filter->equal('st_sn', '编号');
            $filter->scope('trashed', '回收站')->onlyTrashed();
        });
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
        $form->text('name', __('学生姓名'));
        $form->text('st_sn', __('学生编号'));
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->password = Hash::make("Test@comiru.com");
            }
        });
        return $form;
    }
}
