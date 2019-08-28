@extends('adminlte::page')
@section('title', 'Monthly Summary Reports')
@section('content_header')

<h1>SMS Monthly Summary Report ( {{$first_day}} to {{$report_date}} )</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="box-header with-border">
                    <div class="pull-left">
                        {{--  <strong><strong>{{$country_name. '-'. $dept_name}}</strong></strong> --}}
                    </div>
                    <input type="hidden" id="country" value="{{$country_id}}">
                    <input type="hidden" id="department" value="{{$dept_id}}">
                    <input type="hidden" id="report_date" value="{{$report_date}}">
                    <div class="pull-left">
                        <a href="summary_report/generate_excel?country=<?php echo $country_id ?>&department=<?php echo $dept_id ?>&report_date=<?php echo $report_date ?>"
                            class="btn btn-info btn-flat"><strong>EXPORT
                                TO EXCEL</strong></a>
                    </div>
                    {{--  <div class="col-md-12">
                        <button type="submit" name="export" id="exportBtn" class="btn btn-info btn-flat"><strong>EXPORT
                                REPORT</strong></button>
                    </div>  --}}
                    <div class="box-tools">
                        <a href="/reports/summary_report" class="btn bg-purple pull-right"><strong><i
                                    class="fa fa-arrow-left"></i> BACK</strong></a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="example2" class="table table-hover">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Country</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Sent SMS</th>
                                <th>Delivered SMS</th>
                                <th>Failed SMS</th>
                                <th>Pending SMS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($texts as $count=> $item)

                            <tr>
                                <td>{{$count + 1}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$country_name}}</td>
                                <td>{{$dept_name}}</td>
                                <td>{{$year_name}}</td>
                                <td>{{$month_name}}</td>
                                <td>{{$item->sent}}</td>
                                <td>{{$item->delivered}}</td>
                                <td>{{$item->failed}}</td>
                                <td>{{$item->pending}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray font-17 footer-total text-left">
                                <td rowspan="1" colspan="6" class="summary">
                                    <strong>Total:</strong>
                                </td>
                                <td rowspan="1" colspan="1" class="summary">
                                    <span class="display_currency" data-currency_symbol="true">
                                        <strong>{{ number_format($total_delivered,0 ,'.',',') }} SMS</strong></span>
                                </td>
                                <td rowspan="1" colspan="1" class="summary">
                                    <span class="display_currency" data-currency_symbol="true">
                                        <strong>{{ number_format($total_delivered, 0,'.',',') }} SMS</strong></span>
                                </td>
                                <td rowspan="1" colspan="1" class="summary">
                                    <span class="display_currency" data-currency_symbol="true">
                                        <strong>{{ number_format($total_failed, 0,'.',',') }} SMS</strong></span>
                                </td>
                                <td rowspan="1" colspan="1" class="summary">
                                    <span class="display_currency" data-currency_symbol="true">
                                        <strong> {{ number_format($total_pending, 0,'.',',') }} SMS</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- AREA CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">

                    <strong>{{$country_name. '-'. $dept_name. ' ('. $first_day. ' to '.$report_date. ')'}} SMS Report
                        Chart</strong></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="chartJSContainer" height="300"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@stop
@section('css')
<style>
    .summary {
        padding: 8px !important;
    }
</style>
@stop @section('js')
<script>
    // LINE CAHRT
Chart.defaults.scale.gridLines.display = false;
var options = {
    type: 'line',
    data: {
        labels  :<?php echo $all_dates; ?>,
        datasets: [
          {
            label               : 'Sent',
            borderColor         : '#00a65a',
            fillColor           : 'red',
            strokeColor         : 'rgb(218, 107, 222)',
            gridLines:false,
            pointColor          : 'rgb(218, 107, 222)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
           // data                : [20, 48, 85, 87, 73, 56, 43, 13, 25, 43, 37, 36, 36, 34, 12]
            data                : <?php echo $all_sent; ?>
          },
          {
            label               : 'Delivered',
            borderColor         : '#00c0ef',
            gridLines:false,
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
           // data                : [435,674,433,834,644,433,865,453,537,758,543,452,734,136,537]
          data                : <?php echo $all_delivered; ?>
          },
          {
            label               : 'Failed',
            borderColor         : '#bb2124',
            gridLines:false,
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
           //data                : [435,645,645,688,547,234,188,435,536,452,523,534,637,745,454]
            data                : <?php echo $all_failed; ?>
          },
          {
            label               : 'Pending',
            borderColor         : 'yellow',
            gridLines:false,
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo $all_pending; ?>
          }
         
        ]
    },

  }
  
  var ctx = document.getElementById('chartJSContainer').getContext('2d');
  new Chart(ctx, options);

</script>

<script>
    $(function() {
        $(".select2").select2()
        $('#example1').DataTable()
        $('#example2').DataTable()
    })
</script>

<script>
    $(document).ready(function () {
        
        $("#exportBtn").on('click' , function(e) {    
        
            var country = $('#country').val();
            var department = $('#department').val();
            var report_date = $('#report_date').val();
    
            $.ajax({        
                type : 'POST',
                url: '/reports/summary_report/generate_excel',
                data: {'_token':"{{ csrf_token() }}",'country': country, 'department': department, 'report_date': report_date} ,
    
                success: function (data) {
                console.log(data)
                }
                
            })
            
    });

});

</script>
@stop