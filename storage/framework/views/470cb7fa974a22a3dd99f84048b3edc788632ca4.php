<?php $__env->startSection('title', 'Manage SMS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-envelope "></i> Manage SMS</h1>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   
   <p style="padding:15px; text-align:center"><span class="label label-success">SENT</span> status indicate the text send process has started. Click on the view button to check the Entire Progress </p>
   		 <table class="table table-bordered table-striped">  
                <thead>
                <tr>
                  <th style="width:30%">Title</th>
                  <th>Date / Time Created</th>
                  <th>Status</th>
                  <th>Recepient Contacts(s)</th>
                 
                  <?php if(isset($_GET['status_only'])&& $_GET['status_only']=='yes'): ?>
                        
                        
                        <?php else: ?>
                 
                 
                  <th></th>
                  
                  
                  <?php endif; ?>
                
                </tr>
                </thead>
                <tbody>
                
                  <?php if(count($texts)>0): ?>
                  
                  
       
                   
                   		<?php $__currentLoopData = $texts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                        <tr>
                	<td>
                    
                      <?php if($text->qued >= 2): ?>
                        <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>"><strong><?php echo e($text->text_title); ?></strong></a>
                      <?php else: ?>
                       <strong><?php echo e($text->text_title); ?></strong>
                      <?php endif; ?>   
                      
                     <br> <span style="font-size:11px">By : <?php echo e($text->created_by_name); ?></span>                  
                  </td>
                    <td><?php echo e(date("d-m-Y",strtotime($text->created_date))); ?>  (<?php echo e(date("h:i:s a",strtotime($text->created_date))); ?>)</td>
                  
                      
                        <td>
                        
                        
                         <?php if($text->qued ==2): ?>
                       
                       <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>">
                      

<span class="label label-success">SENT</span>

</a>  
                         <?php elseif($text->qued==3 && $text->status !='canceled'): ?>
                        <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>">
                        	<span class="label label-warning">QUEED</span>
                            </a>
                             
                             <?php elseif($text->status=='draft'): ?>
                             
                              <span class="label label-default">DRAFT</span>
                              
                              <?php elseif($text->status=='canceled'): ?>
                               <span class="label label-warning">CANCELED</span>
                              
                      	
                         
                         <?php elseif($text->status=='pending_approval'): ?>
                               <span class="label label-default">PENDING APPROVAL</span>
                               
                               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve text')): ?>
                               
  							  <a href="<?php echo e(url('/')); ?>/text/approvetext/approve/<?php echo e($text->text_id); ?>">
                        	 <span class="label label-info"><i class="fa fa-check"></i> APPROVE</span>
                            </a>
<?php endif; ?>
                              
                      	 <?php else: ?>
                         
                            <span class="label label-default">PROCESSING</span>
                            
                         <?php endif; ?>
                        
                        
                        </td>
                        
                        
                          <td>
                        
                        <?php if($text->contacts_id > 0): ?>
                        
                        	<?php if($text->contacts_from=="csv"): ?>
                             	<a href="/<?php echo e($text->csv_file); ?>"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                        
                             <?php elseif($text->contacts_from="phone_book"): ?>
                            	 <a href="<?php echo e(url('/')); ?>/contact/<?php echo e($text->contacts_id); ?>"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                            <?php endif; ?>
                            
                          <?php else: ?>
                          
                          <a href="#contacts-modal<?php echo e($text->text_id); ?>" data-toggle="modal" data-target="#contacts-modal<?php echo e($text->text_id); ?>">
                          <strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                          	<?php echo $__env->make('texts._recepients_contacts_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                          
                          <?php endif; ?>
                          
                          
                        
                        </td>
                        
                        
                        <?php if(isset($_GET['status_only'])&& $_GET['status_only']=='yes'): ?>
                        
                        
                        <?php else: ?>
                        
                        <td>
                        
                           <?php if($text->status  != 2): ?>
                           		<?php $action_text="View"; $btn_color="info"; ?>
                              
                  <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>" class="btn btn-<?php echo e($btn_color); ?> btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
                                               
       <strong>  <i class="fa fa-file"></i> <?php echo e($action_text); ?></strong>
          </a> &nbsp;
                              <?php else: ?>
                              
                              <?php $action_text="Edit"; $btn_color="warning";?>
                                
                                <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>/edit" class="btn btn-<?php echo e($btn_color); ?> btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
                              
                            <?php endif; ?>
       
          
         
          
           <a href="<?php echo e(url('/')); ?>/text/action_text/<?php echo e($text->text_id); ?>/cancel/" class="btn btn-default btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit" 
           onclick="return confirm('Are you sure you want to Cancel this text?');"
           >
       <strong>  <i class="fa fa-close"></i> Cancel</strong>
          </a>&nbsp;
          
          
                        
                        </td>
                        
                        <?php endif; ?>
                       
                
                </tr>
                   			
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php endif; ?>
                
                
                </tbody>
                </table>
                
                
                  <?php echo e($texts->links()); ?>

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