

<?php $__env->startSection('title', 'Manage Users'); ?>

<?php $__env->startSection('content_header'); ?>
  <h1><i class="fa fa-fw fa-users"></i> Users</h1>
<?php $__env->stopSection(); ?>

<style>
.floatit{ display:inline; margin:0px !important}

</style>

<?php $__env->startSection('content'); ?>
  
          
          
            <div class="box">
            
           
              <div class="box-header with-border">
                <h5 class="box-title">Mananage Users</h5>

              </div>
             
              <div class="box-body">
                 
                  <table id="records" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Names</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Organization</th>
                  <th>Date Created</th>
                  <th>Actions</th>
                
                
                </tr>
                </thead>
                <tbody>
                	<?php if($users->count()>0): ?>
                		<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->role); ?></td>
                                <td><?php echo e($user->organization); ?></td>
                                <td><?php echo e(date("d-m-Y",strtotime($user->created_at))); ?>  (<?php echo e(date("h:i:s a",strtotime($user->created_at))); ?>)</td>
                                <td>
                                
          
            <a href="<?php echo e(url('/')); ?>/admin/user/<?php echo e($user->id); ?>/edit" class="btn btn-warning btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
       <strong>  <i class="fa fa-edit"></i></strong> 
          </a>
          
            
            
            <?php if($current_user!=$user->id): ?>
             
           <?php echo Form::open(['action'=>['Admin\\UserController@destroy',$user->id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?>  
          
          
           <?php echo e(Form::hidden('_method','DELETE')); ?>

           
            <button type="submit" class="btn btn-danger btn-xs btn-flat" onClick="return confirm('Are you sure you want to delete this User?');">   <strong>  <i class="fa fa-close"></i></strong></button>
          
        
          
            <?php echo Form::close(); ?>

            
            <?php endif; ?>
                                
                                </td>
                            
                            </tr>
                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
                
                </table>
                  
                  
             
              </div>
             
              <div class="box-footer">
                
              </div>
              
               
            
            </div>
         
      
   
   
   
   
   
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
  $('#records').DataTable({
    "ordering": false
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>