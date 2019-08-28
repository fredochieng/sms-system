@extends('adminlte::page')

@section('title', 'All SMS Report')

@section('content_header')
<h1><i class="fa fa-fw fa-file "></i> SMS Report</h1>
@stop

<style>
  .floatit {
    float: right;
    margin-bottom: 0px !important
  }
</style>

@section('content')
<div class="box with-border">
  <div class="box-body">
    <strong>EXPORT REPORT: </strong><br><br>

    {!!
    Form::open(['action'=>'ReportsController@all_sms','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
    !!}

    <div class="col-md-4">
      Leave the below options blank and click on Export Report if you need a full import of all SMS, Check any of the
      options to filter.
      <div class="form-group">
        <div class="checkbox">
          <label>
            {{ Form::checkbox('status[]','2',null, array('id'=>'published')) }}
            <!-- <input type="checkbox" name="status[]" value="published">-->
            <strong>Delivered SMS </strong>
          </label>
        </div>
        <div class="checkbox">
          <label>
            {{ Form::checkbox('status[]','3',null, array('id'=>'published')) }}
            <!-- <input type="checkbox" name="status[]" value="published">-->
            <strong> Undelivered SMS</strong>
          </label>
        </div>
        <div class="checkbox">
          <label>
            {{ Form::checkbox('status[]','1',null, array('id'=>'published')) }}
            <!-- <input type="checkbox" name="status[]" value="published">-->
            <strong>Queed SMS</strong>
          </label>

        </div>

        <div class="checkbox">
          <label>
            {{ Form::checkbox('status[]','4',null, array('id'=>'published')) }}
            <!-- <input type="checkbox" name="status[]" value="published">-->
            <strong>Cancelled SMS</strong>
          </label>


        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div>
        {{Form::label('from_date', 'From Date')}}

        <div class="form-group">
          {{Form::text('from_date', '',['class'=>'form-control date','placeholder'=>'Select From Date','autocomplete'=>'off'])}}
        </div>
      </div>

      <div>
        {{Form::label('to_date', 'To Date')}}

        <div class="form-group">
          {{Form::text('to_date', '',['class'=>'form-control date','placeholder'=>'Select To Date','autocomplete'=>'off'])}}
        </div>
      </div>

    </div>
  </div>

  <div class="col-md-12">
    <button type="submit" name="export" class="btn btn-info btn-flat"><strong>EXPORT REPORT</strong></button>
  </div>

  <div style="clear:both"></div><br>
  {!! Form::close() !!}


</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop

@section('js')

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
@stop