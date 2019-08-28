

<?php $__env->startSection('title', 'Manage SMS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-lock"></i> Edit Profile</h1>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   
   <div class="col-md-4">
     <?php echo Form::open(['action'=>'ProfileController@edit','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

     
     <br>
      <div class="col-md-12">
                  
               			  <?php echo e(Form::label('email', 'Your Email / Username')); ?>

                
                         <div class="form-group">
                             <?php echo e(Form::text('email', $email,['class'=>'form-control','placeholder'=>'','readonly'=>'true'])); ?>

                        </div>
                 
                    
                    </div>
                    
                    
                    <div class="col-md-12">
                  
               			  <?php echo e(Form::label('password', 'Your New Password')); ?>

                
                         <div class="form-group">
                                <?php echo e(Form::password('password',['class'=>'form-control','placeholder'=>'Enter Password'])); ?>

                        </div>
                 
                    
                    </div>
                    
                     <div class="col-md-12">
                  
               			  <?php echo e(Form::label('password_confirmation', 'Retype New Password')); ?>

                
                         <div class="form-group">
                                <?php echo e(Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Re-Enter Password'])); ?>

                        </div>
                 
                    
                    </div>
                    
                     <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-flat" name="save">SAVE CHANGES</button>
                    
                    </div>
     
     
     <?php echo Form::close(); ?>

   
   </div>
   
   <div style="clear:both"></div>		 
   </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
     <script>
	// $("#records").DataTable();
	
	 $('#records').DataTable({
    "ordering": false
});
	
	 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>