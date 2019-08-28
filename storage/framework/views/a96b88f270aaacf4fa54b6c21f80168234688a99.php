<?php $__env->startSection('title', 'Advanced SMS Report'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Advanced SMS Report</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Advanced SMS Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <?php echo Form::open(['action'=>'ReportsController@advanced_reports','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

                    <div class="col-md-4">
                        <?php echo e(Form::label('Country ')); ?>

                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="country" name="country[]"
                                required data-placeholder="Select country" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select country</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->recipients_country_id); ?>"><?php echo e($item->country_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php echo e(Form::label('Department ')); ?>

                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="department" name="department[]"
                                required data-placeholder="Select department" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select department</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->department_id); ?>"><?php echo e($item->dept_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php echo e(Form::label('Status ')); ?>

                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="status[]" name="status[]"
                                required data-placeholder="Select status" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select status</option>
                                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->quee_status_id); ?>"><?php echo e($item->quee_status_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div>
                            <?php echo e(Form::label('from_date', 'From Date')); ?>


                            <div class="form-group">
                                <?php echo e(Form::text('from_date', '',['class'=>'form-control date', 'id'=>'from_date','placeholder'=>'Select From Date','autocomplete'=>'off'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <?php echo e(Form::label('from_date', 'To Date')); ?>


                            <div class="form-group">
                                <?php echo e(Form::text('to_date', '',['class'=>'form-control date1','id'=>'to_date','placeholder'=>'Select To Date','autocomplete'=>'off'])); ?>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('Generate Report')); ?>

                        <div class="form-group">
                            <button type="submit" name="export" class="btn btn-info btn-flat"><strong>GENERATE
                                    REPORT</strong></button>
                        </div>
                    </div>
                    <?php $__env->stopSection(); ?>

                    <?php $__env->startSection('css'); ?>
                    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
                    <?php $__env->stopSection(); ?>

                    <?php $__env->startSection('js'); ?>
                    <script src="/js/select2.full.min.js"></script>
                    <script src="/js/bootstrap-datepicker.min.js"></script>
                    <script>
                        $(function() {
                            $(".select2").select2()
                            $('.date').datepicker( { 
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                orientation: "bottom auto"
                            })

                            $("#from_date").change(function() {
                                    var start_date = $("#from_date").val();
                                    var start_date = new Date(start_date);
                                   // var start_date = new Date(start_date);
                                   // var end_date = start_date + 2;
                                   // alert(start_date);
                            });

                            $('.date1').datepicker( { 
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                orientation: "bottom auto"
                            })
                        });    
                    </script>
                    <?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>