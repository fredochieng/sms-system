

<?php $__env->startSection('title', 'Manage  Contacts Lists'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-phone "></i> <?php echo e($contact->contacts_title); ?> Contacts </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div class="box with-border">
   <div class="box-body">
   

   		 <table id="records" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Telephone </th>
                  <th>Email</th>
                
                </tr>
                </thead>
                
                <tbody>
                
                <?php $contacts_array = (array) json_decode($contact->phone_book_contacts);?>
                
       
                
                  <?php if(count($contacts_array)>0): ?>
                   
                   		<?php $__currentLoopData = $contacts_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contacts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   			
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e($contacts->first_name); ?></td>
                                <td><?php echo e($contacts->last_name); ?></td>
                                <td><?php echo e($contacts->phone); ?></td>
                                 <td><?php echo e($contacts->email); ?></td>
                            </tr>
                            
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                   <?php endif; ?>
                
                
                
                
                
                
                </tbody>
           
                </table>
   </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
     <script>
	 $("#records").DataTable();
	
	 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>