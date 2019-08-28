

<?php $__env->startSection('title', 'Reports by Campaign'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-file "></i> Reports by Campaign</h1>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   		 <table class="table table-bordered table-striped">  
                <thead>
                <tr>
                  <th style="width:30%">Title</th>
                  <th>Date / Time Created</th>
                 <!-- <th>Status</th>-->
                  <th>Report</th>
                 
                 
                 
                 
               
                  
                
                
                </tr>
                </thead>
                <tbody>
                
                  <?php if(count($texts)>0): ?>
                   
                   		<?php $__currentLoopData = $texts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                	<td>
                    
                     
                        <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>"><strong><?php echo e($text->text_title); ?></strong></a>
                    
                      
                     <br> <span style="font-size:11px">By : <?php echo e($text->created_by_name); ?></span>                  
                  </td>
                    <td><?php echo e(date("d-m-Y",strtotime($text->created_at))); ?>  (<?php echo e(date("h:i:s a",strtotime($text->created_at))); ?>)</td>
                  
                      
                     <!--   <td>
                        
                        
                       
                       
                       <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>">
                     

<span class="label label-success">0 % SENT</span>

</a>
                         <?php if($text->qued==2 && $text->status !='canceled'): ?>
                        <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>">
                        	<span class="label label-warning">QUEED</span>
                            </a>
                            
                             <?php elseif($text->status=='draft'): ?>
                             
                              <span class="label label-default">DRAFT</span>
                              
                              <?php elseif($text->status=='canceled'): ?>
                               <span class="label label-warning">CANCELED</span>
                              
                      	
                         
                         <?php elseif($text->status=='pending_approval'): ?>
                               <span class="label label-default">PENDING APPROVAL</span>
                               
                            
                      	 <?php else: ?>
                         
                            <span class="label label-default">PROCESSING</span>
                            
                         <?php endif; ?>
                        
                        
                        </td>-->
                        
                        <td>
                       <a href="<?php echo e(url('/')); ?>/reports/generate_excel/<?php echo e($text->text_id); ?>/all" class="btn btn-info btn-flat btn-xs"><strong> <i class="fa fa-fw fa-download"></i> DOWNLOAD SUMMARY REPORT</strong></a> &nbsp; &nbsp;
                       
                        <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text->text_id); ?>" class="btn btn-primary btn-flat btn-xs"><strong> <i class="fa fa-fw fa-file "></i> VIEW DETAILED REPORT</strong></a>
                        
                        </td>
                        
                        
                       
                        
                        
                      
                
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