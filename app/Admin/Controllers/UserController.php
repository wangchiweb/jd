<?php

namespace App\Admin\Controllers;

use App\Model\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('user_id', __('User id'));
        $grid->column('user_name', __('User name'));
        $grid->column('user_email', __('User email'));
        $grid->column('user_tel', __('User tel'));
        $grid->column('user_pwd', __('User pwd'));
        $grid->column('confirm_pwd', __('Confirm pwd'));
        $grid->column('register_time', __('Register time'));
        $grid->column('last_login_time', __('Last login time'));
        $grid->column('last_login_ip', __('Last login ip'));
        $grid->column('login_count', __('Login count'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('user_id', __('User id'));
        $show->field('user_name', __('User name'));
        $show->field('user_email', __('User email'));
        $show->field('user_tel', __('User tel'));
        $show->field('user_pwd', __('User pwd'));
        $show->field('confirm_pwd', __('Confirm pwd'));
        $show->field('register_time', __('Register time'));
        $show->field('last_login_time', __('Last login time'));
        $show->field('last_login_ip', __('Last login ip'));
        $show->field('login_count', __('Login count'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('user_name', __('User name'));
        $form->text('user_email', __('User email'));
        $form->text('user_tel', __('User tel'));
        $form->text('user_pwd', __('User pwd'));
        $form->text('confirm_pwd', __('Confirm pwd'));
        $form->number('register_time', __('Register time'));
        $form->number('last_login_time', __('Last login time'));
        $form->text('last_login_ip', __('Last login ip'));
        $form->number('login_count', __('Login count'));

        return $form;
    }
}
