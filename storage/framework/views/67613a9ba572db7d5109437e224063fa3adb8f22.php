<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Dashboard</h1>
<?php $__env->stopSection(); ?>
<style>
    .info-box-icon {

        background-color: red;
        background-size: cover;
    }
</style>
<?php $__env->startSection('content'); ?>

<div class="row">

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>0</h3>

                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-timer"></i>
            </div>
            <a href="messages.php?status=Pending" class="small-box-footer">More info <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>0</h3>

                <p>Queued</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-sync"></i>
            </div>
            <a href="messages.php?status=Queued" class="small-box-footer">More info <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>0</h3>

                <p>Sent</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-done-all"></i>
            </div>
            <a href="messages.php?status=Sent" class="small-box-footer">More info <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>0</h3>

                <p>Failed</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-remove-circle"></i>
            </div>
            <a href="messages.php?status=Failed" class="small-box-footer">More info <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">SMS Balance</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <?php if($ke_bal > 2000000): ?>
                        <div class="info-box bg-aqua">
                            <?php else: ?>
                            <div class="info-box bg-red">
                                <?php endif; ?>
                                <span class="info-box-icon">
                                    <a href="http://flagpedia.net/kenya"><img alt="Flag of Kenya"
                                            src="http://flagpedia.net/data/flags/small/ke.png" width="90"
                                            height="90" /></a>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">KENYA</span>
                                    <span class="info-box-number">KES <?php echo e(number_format($ke_bal, 0 ,'.', ',')); ?></span>
                                    <span class="progress-description">
                                        <?php if($ke_bal < 2000000): ?> Bal. below threshold <?php endif; ?> </span>
                                            <!-- /.info-box-content -->

                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <?php if($tz_bal['balance'][1] > 5000000): ?>
                            <div class="info-box bg-aqua">
                                <?php else: ?>
                                <div class="info-box bg-red">
                                    <?php endif; ?>

                                    <span class="info-box-icon">
                                        <a href="http://flagpedia.net/tanzania"><img alt="Flag of Tanzania"
                                                src="http://flagpedia.net/data/flags/small/tz.png" width="90"
                                                height="90" /></a>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">TANZANIA</span>
                                        <span class="info-box-number"><?php echo e($tz_bal['balance'][0]); ?>

                                            <?php echo e(number_format($tz_bal['balance'][1], 0 ,'.', ',')); ?></span>
                                        <span class="progress-description">
                                            <?php if($tz_bal['balance'][1] < 5000000): ?> Bal. below threshold <?php endif; ?> </span>
                                                </div> <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <?php if($tz_bal['balance'][1] > 800000): ?>
                                    <div class="info-box bg-aqua">
                                        <?php else: ?>
                                        <div class="info-box bg-red">
                                            <?php endif; ?>
                                            <span class="info-box-icon">
                                                <a href="http://flagpedia.net/uganda"><img alt="Flag of Uganda"
                                                        src="http://flagpedia.net/data/flags/small/ug.png" width="90"
                                                        height="90" /></a>
                                            </span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">UGANDA</span>
                                                <span class="info-box-number"><?php echo e($ug_bal['balance'][0]); ?>

                                                    <?php echo e(number_format($ug_bal['balance'][1], 0, '.', ',')); ?></span>

                                                <span class="progress-description">
                                                    <?php if($ug_bal['balance'][1] < 800000): ?> Bal. below threshold <?php endif; ?>
                                                        </span> </div> <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <?php if($ml_bal['balance'][1] > 1400000): ?>
                                            <div class="info-box bg-aqua">
                                                <?php else: ?>
                                                <div class="info-box bg-red">
                                                    <?php endif; ?>
                                                    <span class="info-box-icon">
                                                        <a href="http://flagpedia.net/malawi"><img alt="Flag of Malawi"
                                                                src="http://flagpedia.net/data/flags/small/mw.png"
                                                                width="90" height="90" /></a>
                                                    </span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">MALAWI</span>
                                                        <span class="info-box-number"><?php echo e($ml_bal['balance'][0]); ?>

                                                            <?php echo e(number_format($ml_bal['balance'][1], 0, '.', ',')); ?></span>

                                                        <span class="progress-description">
                                                            <?php if($ml_bal['balance'][1] < 1400000): ?> Bal. below threshold
                                                                <?php endif; ?> </span> </div> <!-- /.info-box-content -->
                                                    </div>
                                                    <!-- /.info-box -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-3 col-sm-6 col-xs-12">
                                                    <?php if($za_bal['balance'][1] > 250000): ?>
                                                    <div class="info-box bg-aqua">
                                                        <?php else: ?>
                                                        <div class="info-box bg-red">
                                                            <?php endif; ?>
                                                            <span class="info-box-icon">
                                                                <a href="http://flagpedia.net/zambia"><img
                                                                        alt="Flag of Zambia"
                                                                        src="http://flagpedia.net/data/flags/small/zm.png"
                                                                        width="90" height="90" /></a>
                                                            </span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">ZAMBIA</span>
                                                                <span class="info-box-number"><?php echo e($za_bal['balance'][0]); ?>

                                                                    <?php echo e(number_format($za_bal['balance'][1], 0, '.', ',')); ?></span>

                                                                <span class="progress-description">
                                                                    <?php if($za_bal['balance'][1] < 250000): ?> Bal. below
                                                                        threshold <?php endif; ?> </span> </div>
                                                                        <!-- /.info-box-content -->
                                                            </div>
                                                            <!-- /.info-box -->
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box -->
                                        </div>
                                    </div>
                                    <?php $__env->stopSection(); ?>

                                    <?php $__env->startSection('css'); ?>
                                    <link rel="stylesheet" href="/css/admin_custom.css">
                                    <?php $__env->stopSection(); ?>

                                    <?php $__env->startSection('js'); ?>
                                    <script>
                                        $( document ).ready(function() {
                                               
                                            });
                                    </script>
                                    <?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>