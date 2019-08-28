<?php $__env->startSection('title', 'Create User'); ?>

<?php $__env->startSection('content_header'); ?>
<h1><i class="fa fa-fw fa-users "></i> Create User</h1>
<?php $__env->stopSection(); ?>

<style>
</style>

<?php $__env->startSection('content'); ?>
<div class="box with-border">


    <div class="box-body">

        <?php echo Form::open(['action'=>'Admin\\UserController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

        <div class="box-body">

            <div class="row">
                <div class="col-md-6">
                    <?php echo e(Form::label('full_names', 'Full Names* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('full_names', '',['class'=>'form-control', 'placeholder'=>'User Full Names', 'required'=>'required'])); ?>

                    </div>
                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('telephone', 'Telephone ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('telephone', '',['class'=>'form-control', 'placeholder'=>'Enter Telephone'])); ?>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <?php echo e(Form::label('email', 'Email')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('email', '',['class'=>'form-control', 'placeholder'=>'Enter The user Email', 'required'=>'required'])); ?>

                    </div>
                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('password', 'Password* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::password('password',['class'=>'form-control', 'placeholder'=>'Enter a strong Password', 'required'=>'required'])); ?>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    <?php echo e(Form::label('role', 'Role')); ?>


                    <div class="form-group">
                        <?php echo e(Form::select('role', $roles,null, ['class' => 'form-control','placeholder'=>'--Select the User Role--'])); ?>

                    </div>

                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('organization', 'Organization* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::select('organization', $organizations,null, ['class' => 'form-control','placeholder'=>'--Select the User Organization--'])); ?>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    <?php echo e(Form::label('role', 'User Country')); ?>


                    <div class="form-group">
                        <?php echo e(Form::select('country', $countries,null, ['class' => 'form-control','placeholder'=>'--Select the User Country--'])); ?>

                    </div>

                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('organization', 'User Department* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::select('department', $departments,null, ['class' => 'form-control','placeholder'=>'--Select the User Department--'])); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">SUBMIT DETAILS</button>

        </div>

        <?php echo Form::close(); ?>

    </div>

</div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/vendor/adminlte/plugins/iCheck/square/blue.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>