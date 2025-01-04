<?php

namespace App\Admin\Controllers;

use App\Model\TTeacher;
use App\Services\UserService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class TTeacherController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '教师中心';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TTeacher());
        $grid->column('id', 'ID')->sortable();
        $grid->column('id', __('教师ID'));
        $grid->column('t_sn', __('教师编号'));
        $grid->column('name', __('姓名'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->row->slug == 'administrator') {
                $actions->disableDelete();
            }
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });
        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('name', '姓名');
            $filter->equal('t_sn', '编号');
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
        $show = new Show(TTeacher::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('教师姓名'));
        $show->field('t_sn', __('教师编号'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TTeacher());
        $form->text('name', __('教师姓名'));
        if($form->isCreating()){
            $form->text('t_sn', __('教师编号'));
        }else{
            $form->text('t_sn', __('教师编号'))->disable();;
        }
        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->password = Hash::make("Test@comiru.com");
            }
        });
        $form->saved(function (Form $form) {
            //$teacherId = $form->model()->id;
            //todo 使用事件最合理，目前不同域的业务逻辑混合在一起了。
            UserService::createUserFromTeacher($form->model()->t_sn,$form->model()->name);
        });
        return $form;
    }
}
