

<?php $__env->startSection('title', 'Manage  Contacts Lists'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-phone "></i> Manage Contacts Lists</h1>
<?php $__env->stopSection(); ?>

<style>

.floatit{ float:right; margin-bottom:0px !important}
</style>

<?php $__env->startSection('content'); ?>
   <div class="box with-border">
   <div class="box-body">
   

   		 <table id="records" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                  <th>Title</th>
                  <th>Date Created</th>
                  
                   <th>Contact type</th>
                  <th>View Contacts</th>
                  <th>Actions</th>
                
                </tr>
                </thead>
                <tbody>
                
                
                   <?php if(count($contacts)>0): ?>
                   
                   		<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contacts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   			
                            <tr>
                            <td><?php echo e($key+1); ?></td>
                            	<td><?php echo e($contacts->contacts_title); ?></td>
                                <td><?php echo e(date("d-m-Y",strtotime($contacts->created_at))); ?></td>
                                
                                <td>
                                	<?php if($contacts->contacts_from=='csv'): ?>
                                    
                                   			<i class="fa fa-fw fa-file"></i> CSV File 
                                    <?php elseif($contacts->contacts_from=='phone_book'): ?>
                                    		<i class="fa fa-fw fa-book"></i>	Phone Book
                                  
                                    
                                    <?php endif; ?>
                                
                                
                                
                                </td>
                            	
                                <td>
                                	<?php if($contacts->contacts_from=='csv'): ?>
                                     
                                   			<a href="/<?php echo e($contacts->csv_file); ?>"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                                    <?php elseif($contacts->contacts_from=='phone_book'): ?>
                                    		<a href="<?php echo e(url('/')); ?>/contact/<?php echo e($contacts->contacts_id); ?>"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                                  
                                    
                                    <?php endif; ?>
                                
                                
                                
                                </td>
                                <td>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                             
          
          
           <a href="/contact/<?php echo e($contacts->contacts_id); ?>/edit" class="btn btn-warning btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
       <strong>  <i class="fa fa-edit"></i></strong>
          </a>
          
          
          
                <!--<form action="<?php echo e(route('contact.destroy', $contacts->contacts_id)); ?>" method="post" style="float:right">-->
                
                 <?php echo Form::open(['action'=>['ContactController@destroy',$contacts->contacts_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']); ?>  
          
            <?php echo e(csrf_field()); ?>

           <?php echo e(Form::hidden('_method','DELETE')); ?>

           
            <button type="submit" class="btn btn-danger btn-xs btn-flat"  onClick="return confirm('Are you sure you want to delete this contact? All the Text messages associated with it will also be deleted. Click OK to Continue');">   <strong>  <i class="fa fa-close"></i></strong></button>
          
        
          
          </form>
                    
                                
                                
                                
                                
                                
                                
                                </td>
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