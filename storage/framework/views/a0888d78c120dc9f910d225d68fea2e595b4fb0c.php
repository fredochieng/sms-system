

<?php $__env->startSection('title', 'All SMS Report'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-file "></i> SMS Report</h1>
<?php $__env->stopSection(); ?>

<style>

.floatit{ float:right; margin-bottom:0px !important}
</style>

<?php $__env->startSection('content'); ?>
   <div class="box with-border">
   <div class="box-body">
   	<strong>EXPORT REPORT: </strong><br><br>
           
            
            <?php echo Form::open(['action'=>'ReportsController@all_sms','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            
             
             <div class="col-md-4">
              Leave the below options blank and click on Export Report if you need a full import of all SMS, Check any of the options to filter.
              <div class="form-group">
                  <div class="checkbox">
                  
                
                    <label>
                    <?php echo e(Form::checkbox('status[]','2',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Delivered SMS </strong>
                    </label>
                    </div>
                     <div class="checkbox">
                     <label>
                    <?php echo e(Form::checkbox('status[]','3',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     <strong>	Undelivered SMS</strong>
                    </label>
                    </div>
                    <div class="checkbox">
                     <label>
                    <?php echo e(Form::checkbox('status[]','1',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Queed SMS</strong>
                    </label>
                    
                    </div>
                    
                      <div class="checkbox">
                     <label>
                    <?php echo e(Form::checkbox('status[]','4',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Cancelled SMS</strong>
                    </label>
                    
                    
                  </div> 
                  </div>
                  </div>
                  
                    <div class="col-md-4">
                   <div>
  <?php echo e(Form::label('from_date', 'From Date')); ?>


 <div class="form-group">
     <?php echo e(Form::text('from_date', '',['class'=>'form-control date','placeholder'=>'Select From Date','autocomplete'=>'off'])); ?>

</div>
            	   </div>
                   
<div>
  <?php echo e(Form::label('to_date', 'To Date')); ?>


 <div class="form-group">
     <?php echo e(Form::text('to_date', '',['class'=>'form-control date','placeholder'=>'Select To Date','autocomplete'=>'off'])); ?>

</div>
            	   </div>
                   
                   </div>
                  </div>
                  
                 <div class="col-md-12">
                <button type="submit" name="export" class="btn btn-info btn-flat" ><strong>EXPORT REPORT</strong></button>
            </div>
            
            <div style="clear:both"></div><br>
             <?php echo Form::close(); ?>


   		
   </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
     <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="/js/bootstrap-datepicker.min.js"></script>
     <script>
	 
	
	 $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
	 $('.date').datepicker( { 
	 	format: 'dd-mm-yyyy',
		 autoclose: true,
		 orientation: "bottom auto"
	 })
 })
	
	 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>