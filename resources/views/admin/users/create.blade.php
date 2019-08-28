@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
<h1><i class="fa fa-fw fa-users "></i> Create User</h1>
@stop

<style>
</style>

@section('content')
<div class="box with-border">


    <div class="box-body">

        {!!
        Form::open(['action'=>'Admin\\UserController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
        !!}
        <div class="box-body">

            <div class="row">
                <div class="col-md-6">
                    {{Form::label('full_names', 'Full Names* ')}}
                    <div class="form-group">
                        {{Form::text('full_names', '',['class'=>'form-control', 'placeholder'=>'User Full Names', 'required'=>'required'])}}
                    </div>
                </div>

                <div class="col-md-6">
                    {{Form::label('telephone', 'Telephone ')}}
                    <div class="form-group">
                        {{Form::text('telephone', '',['class'=>'form-control', 'placeholder'=>'Enter Telephone'])}}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    {{Form::label('email', 'Email')}}
                    <div class="form-group">
                        {{Form::text('email', '',['class'=>'form-control', 'placeholder'=>'Enter The user Email', 'required'=>'required'])}}
                    </div>
                </div>

                <div class="col-md-6">
                    {{Form::label('password', 'Password* ')}}
                    <div class="form-group">
                        {{Form::password('password',['class'=>'form-control', 'placeholder'=>'Enter a strong Password', 'required'=>'required'])}}
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    {{Form::label('role', 'Role')}}

                    <div class="form-group">
                        {{ Form::select('role', $roles,null, ['class' => 'form-control','placeholder'=>'--Select the User Role--']) }}
                    </div>

                </div>

                <div class="col-md-6">
                    {{Form::label('organization', 'Organization* ')}}
                    <div class="form-group">
                        {{ Form::select('organization', $organizations,null, ['class' => 'form-control','placeholder'=>'--Select the User Organization--']) }}
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    {{Form::label('role', 'User Country')}}

                    <div class="form-group">
                        {{ Form::select('country', $countries,null, ['class' => 'form-control','placeholder'=>'--Select the User Country--']) }}
                    </div>

                </div>

                <div class="col-md-6">
                    {{Form::label('organization', 'User Department* ')}}
                    <div class="form-group">
                        {{ Form::select('department', $departments,null, ['class' => 'form-control','placeholder'=>'--Select the User Department--']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">SUBMIT DETAILS</button>

        </div>

        {!! Form::close() !!}
    </div>

</div>

</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/vendor/adminlte/plugins/iCheck/square/blue.css">
@stop

@section('js')


@stop