<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content_header'); ?>
<h1><i class="fa fa-fw fa-users "></i> Edit User</h1>
<?php $__env->stopSection(); ?>

<style>



</style>

<?php $__env->startSection('content'); ?>
<div class="box with-border">


    <div class="box-body">
        <?php echo Form::open(['action'=>['Admin\\UserController@update',$user->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>


        <div class="box-body">

            <div class="row">
                <div class="col-md-6">
                    <?php echo e(Form::label('full_names', 'Full Names* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('full_names', $user->name,['class'=>'form-control', 'placeholder'=>'User Full Names', 'required'=>'required'])); ?>

                    </div>
                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('telephone', 'Telephone ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('telephone',  $user->telephone,['class'=>'form-control', 'placeholder'=>'Enter Telephone'])); ?>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <?php echo e(Form::label('email', 'Email')); ?>

                    <div class="form-group">
                        <?php echo e(Form::text('email',  $user->email,['class'=>'form-control', 'placeholder'=>'Enter The user Email', 'required'=>'required'])); ?>

                    </div>
                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('password', 'Password* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::password('password',['class'=>'form-control', 'placeholder'=>'Enter a strong Password'])); ?>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    <?php echo e(Form::label('role', 'Role')); ?>


                    <div class="form-group">
                        <?php echo e(Form::select('role', $roles,$user->role_id, ['class' => 'form-control','placeholder'=>'--Select the User Role--'])); ?>

                    </div>

                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('organization', 'Organization* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::select('organization', $organizations, $user->organization_id, ['class' => 'form-control','placeholder'=>'--Select the User Organization--'])); ?>

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">

                    <?php echo e(Form::label('country', 'User Country')); ?>


                    <div class="form-group">
                        <?php echo e(Form::select('country', $countries,$user->country_id, ['class' => 'form-control','placeholder'=>'--Select the User Country--'])); ?>

                    </div>

                </div>

                <div class="col-md-6">
                    <?php echo e(Form::label('department', 'User Department* ')); ?>

                    <div class="form-group">
                        <?php echo e(Form::select('department[]', $departments, $user->department_id, ['class' => 'form-control select2', 'multiple'=>'multiple','placeholder'=>'--Select the User Department--'])); ?>

                    </div>
                </div>

            </div>
        </div>



        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">UPDATE USER</button>

        </div>

        <?php echo e(Form::hidden('_method','PUT')); ?>


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
<script>
    $(function() {
        $(".select2").select2()
    });    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>