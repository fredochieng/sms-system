@extends('adminlte::page')

@section('title', 'Advanced SMS Report')

@section('content_header')
<h1>Advanced SMS Report</h1>
@stop
@section('content')
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
                    {!!
                    Form::open(['action'=>'ReportsController@advanced_reports','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                    !!}
                    <div class="col-md-4">
                        {{Form::label('Country ')}}
                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="country" name="country[]"
                                required data-placeholder="Select country" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select country</option>
                                @foreach($countries as $item)
                                <option value="{{ $item->recipients_country_id }}">{{ $item->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{Form::label('Department ')}}
                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="department" name="department[]"
                                required data-placeholder="Select department" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select department</option>
                                @foreach($departments as $item)
                                <option value="{{ $item->department_id }}">{{ $item->dept_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{Form::label('Status ')}}
                        <div class="form-group">
                            <select class="form-control select2" multiple="multiple" id="status[]" name="status[]"
                                required data-placeholder="Select status" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select status</option>
                                @foreach($status as $item)
                                <option value="{{ $item->quee_status_id }}">{{ $item->quee_status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div>
                            {{Form::label('from_date', 'From Date')}}

                            <div class="form-group">
                                {{Form::text('from_date', '',['class'=>'form-control date', 'id'=>'from_date','placeholder'=>'Select From Date','autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            {{Form::label('from_date', 'To Date')}}

                            <div class="form-group">
                                {{Form::text('to_date', '',['class'=>'form-control date1','id'=>'to_date','placeholder'=>'Select To Date','autocomplete'=>'off'])}}
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        {{Form::label('Generate Report')}}
                        <div class="form-group">
                            <button type="submit" name="export" class="btn btn-info btn-flat"><strong>GENERATE
                                    REPORT</strong></button>
                        </div>
                    </div>
                    @stop

                    @section('css')
                    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
                    @stop

                    @section('js')
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
                    @stop