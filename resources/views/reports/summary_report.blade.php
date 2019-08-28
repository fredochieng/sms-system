@extends('adminlte::page')
@section('title', 'SMS Summary Report')
@section('content_header')
<h1>SMS Summary Report</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info" id="accordion">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filters
                    </a>

                </h3>
                <h3 class="box-title pull-right">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        Daily Summary Report
                    </a>

                </h3>

            </div>
            <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                <div class="box-body">
                    {!!
                    Form::open(['action'=>'ReportsController@show_summary_report','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                    !!}
                    <div class="col-md-12">
                        <div class="col-md-3">
                            {{Form::label('Country ')}}
                            <div class="form-group">
                                <select class="form-control select2" id="country_id" name="country_id" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select country</option>
                                    @foreach($countries as $item)
                                    <option value="{{ $item->recipients_country_id }}">{{ $item->country_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{Form::label('Entity/department ')}}
                            <div class="form-group">
                                <select class="form-control select2" id="dept_id" name="dept_id" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select entity/department</option>
                                    @foreach($departments as $item)
                                    <option value="{{ $item->department_id }}">{{ $item->dept_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                {{Form::label('from_date', 'Date')}}

                                <div class="form-group">
                                    {{Form::text('report_date', '',['class'=>'form-control date', 'required', 'id'=>'report_dates','placeholder'=>'Select Date','autocomplete'=>'off'])}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" name="generate_daily" style="margin-top:25px;"
                                class="btn btn-block btn-info"><strong><i class="fa fa-file-excel-o"></i> Daily
                                    Report</strong></button>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="generate_monthly" style="margin-top:25px;"
                                class="btn btn-block btn-primary"><strong><i class="fa fa-file-excel-o"></i> Monthly
                                    Report</strong></button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/plugins/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('js')
<script src="/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function() {
        $(".select2").select2()
        $('.date').datepicker( { 
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: "bottom auto",
            endDate: new Date(),
        })
    });    
</script>
<script type="text/javascript">
    $(function() {
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();
    $('#report_dates').datepicker({
            maxDate: 0) 
    });
    });
</script>
@stop