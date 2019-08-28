

<?php $__env->startSection('title', 'Manage SMS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-envelope "></i> <?php echo e($text_details->text_title); ?> Progress</h1>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>



   <div class="box with-border">
   <div class="box-body">
   <br>
   
   <div class="col-md-3">
   
   <!--<h4 class="box-title"><i class="fa fa-fw fa-envelope "></i> <?php echo e($text_details->text_title); ?> </h4>-->
   
   <h2><?php echo e(number_format(count($all_texts))); ?> <span style="font-size:12px !important"><strong>Contacts</strong></span></h2>
   
   <div class="clearfix">
                    <span class="pull-left">Overall Progress</span>
                    <small class="pull-right"><?php echo e($percentage_progress); ?> %</small>
                  </div>
   <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: <?php echo e($percentage_progress); ?>%;"></div>
                  </div>
   
   </div>
   
    <div class="col-md-9">
   		<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo e(number_format($sent_texts->count())); ?></h3>

              <p>SMS DELIVERED</p>
            </div>
            <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text_details->text_id); ?>/delivered/status" class="small-box-footer">View Delivered SMS <i class="fa fa-arrow-circle-right"></i></a>
            
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo e(number_format($queed_texts->count())); ?></h3>

              <p>SMS IN QUE</p>
            </div>
            
             <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text_details->text_id); ?>/queed/status" class="small-box-footer">View  SMS in Quee <i class="fa fa-arrow-circle-right"></i></a>
           
          </div>
          
        </div>
        
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo e(number_format($cancelled_texts->count())); ?></h3>

              <p>SMS UNDELIVERED</p>
            </div>
           
             <a href="<?php echo e(url('/')); ?>/text/<?php echo e($text_details->text_id); ?>/undelivered/status" class="small-box-footer">View Undelivered SMS <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
       
        
        </div>
        
        <div style="clear:both"></div>
        
         <hr>
         <?php echo $__env->make('reports._filter_controls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <hr> 
        
       
   </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

     <script>
	// $("#records").DataTable();
	
	 $('.records').DataTable({
    "ordering": false
});
	
	 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>