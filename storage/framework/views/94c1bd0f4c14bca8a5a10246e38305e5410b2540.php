<?php $__env->startSection('title', 'Daily Summary Reports'); ?>
<?php $__env->startSection('content_header'); ?>

<h1>SMS Daily Summary Report - <?php echo e($date); ?></h1>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">

    <div class="col-md-12">

        <div class="box box-info">

            <div class="box-body">
                <div class="box-header with-border">
                    <div class="pull-left">

                        
                        <button type="submit" name="export" id="exportBtn"
                            class="btn btn-info btn-flat"><strong>GENERATE
                                REPORT</strong></button>

                        <strong><?php echo e($country_name. '-'. $dept_name); ?></strong>


                    </div>
                    <div class="box-tools">
                        <a href="/reports/summary_report" class="btn bg-purple pull-right"><strong><i
                                    class="fa fa-arrow-left"></i> BACK</strong></a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-no-margin" id="example1">
                        <thead>
                            <tr>
                                <th>Report Date</th>
                                <th>Country</th>
                                <th>Department</th>
                                <th>Sent SMS</th>
                                <th>Delivered SMS</th>
                                <th>Failed SMS</th>
                                <th>Pending SMS</th>
                            </tr>
                        </thead>
                        <tbody>


                            <td><?php echo e($date); ?></td>
                            <td><?php echo e($country_name); ?></td>
                            <td><?php echo e($dept_name); ?></td>
                            <td><?php echo e($sent); ?></td>
                            <td><?php echo e($delivered); ?></td>
                            <td><?php echo e($failed); ?></td>
                            <td><?php echo e($pending); ?></td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <!-- AREA CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <h3 class="box-title"><strong><?php echo e($country_name. '-'. $dept_name. ' ('. $date. ')'); ?> SMS Report
                            Chart</strong></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="myChart" style="height:337px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total SMS Sent</span>
                <span class="info-box-number">
                    <?php echo e($sent); ?> SMS</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total SMS Delivered</span>
                <span class="info-box-number">
                    <?php echo e($delivered); ?> SMS</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total SMS Pending</span>
                <span class="info-box-number">
                    <?php echo e($pending); ?> SMS</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total SMS Failed</span>
                <span class="info-box-number">
                    <?php echo e($failed); ?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col (LEFT) -->

    <!-- /.col (RIGHT) -->
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?> <?php $__env->startSection('js'); ?>
<script>
    Chart.defaults.doughnutLabels = Chart.helpers.clone(Chart.defaults.doughnut);

var helpers = Chart.helpers;
var defaults = Chart.defaults;

Chart.controllers.doughnutLabels = Chart.controllers.doughnut.extend({
updateElement: function(arc, index, reset) {
var _this = this;
var chart = _this.chart,
chartArea = chart.chartArea,
opts = chart.options,
animationOpts = opts.animation,
arcOpts = opts.elements.arc,
centerX = (chartArea.left + chartArea.right) / 2,
centerY = (chartArea.top + chartArea.bottom) / 2,
startAngle = opts.rotation, // non reset case handled later
endAngle = opts.rotation, // non reset case handled later
dataset = _this.getDataset(),
circumference = reset && animationOpts.animateRotate ? 0 : arc.hidden ? 0 :
_this.calculateCircumference(dataset.data[index]) * (opts.circumference / (2.0 * Math.PI)),
innerRadius = reset && animationOpts.animateScale ? 0 : _this.innerRadius,
outerRadius = reset && animationOpts.animateScale ? 0 : _this.outerRadius,
custom = arc.custom || {},
valueAtIndexOrDefault = helpers.getValueAtIndexOrDefault;

helpers.extend(arc, {
// Utility
_datasetIndex: _this.index,
_index: index,

// Desired view properties
_model: {
x: centerX + chart.offsetX,
y: centerY + chart.offsetY,
startAngle: startAngle,
endAngle: endAngle,
circumference: circumference,
outerRadius: outerRadius,
innerRadius: innerRadius,
label: valueAtIndexOrDefault(dataset.label, index, chart.data.labels[index])
},

draw: function () {
var ctx = this._chart.ctx,
vm = this._view,
sA = vm.startAngle,
eA = vm.endAngle,
opts = this._chart.config.options;

var labelPos = this.tooltipPosition();
var segmentLabel = vm.circumference / opts.circumference * 100;

ctx.beginPath();

ctx.arc(vm.x, vm.y, vm.outerRadius, sA, eA);
ctx.arc(vm.x, vm.y, vm.innerRadius, eA, sA, true);

ctx.closePath();
ctx.strokeStyle = vm.borderColor;
ctx.lineWidth = vm.borderWidth;

ctx.fillStyle = vm.backgroundColor;

ctx.fill();
ctx.lineJoin = 'bevel';

if (vm.borderWidth) {
ctx.stroke();
}

if (vm.circumference > 0.15) { // Trying to hide label when it doesn't fit in segment
ctx.beginPath();
ctx.font = helpers.fontString(opts.defaultFontSize, opts.defaultFontStyle, opts.defaultFontFamily);
ctx.fillStyle = "#fff";
ctx.textBaseline = "top";
ctx.textAlign = "center";

// Round percentage in a way that it always adds up to 100%
ctx.fillText(segmentLabel.toFixed(0) + "%", labelPos.x, labelPos.y);
}
}
});

var model = arc._model;
model.backgroundColor = custom.backgroundColor ? custom.backgroundColor : valueAtIndexOrDefault(dataset.backgroundColor,
index, arcOpts.backgroundColor);
model.hoverBackgroundColor = custom.hoverBackgroundColor ? custom.hoverBackgroundColor :
valueAtIndexOrDefault(dataset.hoverBackgroundColor, index, arcOpts.hoverBackgroundColor);
model.borderWidth = custom.borderWidth ? custom.borderWidth : valueAtIndexOrDefault(dataset.borderWidth, index,
arcOpts.borderWidth);
model.borderColor = custom.borderColor ? custom.borderColor : valueAtIndexOrDefault(dataset.borderColor, index,
arcOpts.borderColor);

// Set correct angles if not resetting
if (!reset || !animationOpts.animateRotate) {
if (index === 0) {
model.startAngle = opts.rotation;
} else {
model.startAngle = _this.getMeta().data[index - 1]._model.endAngle;
}

model.endAngle = model.startAngle + model.circumference;
}

arc.pivot();
}
});

var sent = <?php echo $sent ?>;
var delivered =  <?php echo $delivered ?>;
var failed =  <?php echo $failed ?>;
var pending =  <?php echo $pending ?>;

var config = {
type: 'doughnutLabels',
data: {
datasets: [{
data: [
sent,
delivered,
pending,
failed
],
backgroundColor: [
"#00a65a",
"#00c0ef",
"#f39c12",
"#bb2124"
],
label: 'Dataset 1'
}],
labels: [
"Sent",
"Delivered",
"Pending",
"Failed"
]
},
options: {
responsive: true,
legend: {
position: 'top',
},
title: {
display: false,
text: 'Investments Chart'
},
animation: {
animateScale: true,
animateRotate: true
}
}
};

var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx, config);

</script>
<script>
    $(document).ready(function () {
        
        $("#exportBtn").on('click' , function(e) {    
        
            var sent = <?php echo $sent ?>;
            var delivered =  <?php echo $delivered ?>;
            var failed =  <?php echo $failed ?>;
            var pending =  <?php echo $pending ?>;
    
        
            $.ajax({        
                type : 'post',
                url: '/reports/summary_report/generate_excel',
                data: {'_token':"<?php echo e(csrf_token()); ?>",'sent': parseInt(sent)} ,
    
                success: function (data) {
                console.log(data)
                }
                
            })


    });

});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>