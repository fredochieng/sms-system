@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<h1><i class="fa fa-fw fa-users "></i> Edit User</h1>
@stop

<style>



</style>

@section('content')
<div class="box with-border">


    <div class="box-body">
        {!!
        Form::open(['action'=>['Admin\\UserController@update',$user->id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
        !!}

        <div class="box-body">

            <div class="row">
                <div class="col-md-6">
                    {{Form::label('full_names', 'Full Names* ')}}
                    <div class="form-group">
                        {{Form::text('full_names', $user->name,['class'=>'form-control', 'placeholder'=>'User Full Names', 'required'=>'required'])}}
                    </div>
                </div>

                <div class="col-md-6">
                    {{Form::label('telephone', 'Telephone ')}}
                    <div class="form-group">
                        {{Form::text('telephone',  $user->telephone,['class'=>'form-control', 'placeholder'=>'Enter Telephone'])}}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    {{Form::label('email', 'Email')}}
                    <div class="form-group">
                        {{Form::text('email',  $user->email,['class'=>'form-control', 'placeholder'=>'Enter The user Email', 'required'=>'required'])}}
                    </div>
                </div>

                <div class="col-md-6">
                    {{Form::label('password', 'Password* ')}}
                    <div class="form-group">
                        {{Form::password('password',['class'=>'form-control', 'placeholder'=>'Enter a strong Password'])}}
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">

                    {{Form::label('role', 'Role')}}

                    <div class="form-group">
                        {{ Form::select('role', $roles,$user->role_id, ['class' => 'form-control','placeholder'=>'--Select the User Role--']) }}
                    </div>

                </div>

                <div class="col-md-6">
                    {{Form::label('organization', 'Organization* ')}}
                    <div class="form-group">
                        {{ Form::select('organization', $organizations, $user->organization_id, ['class' => 'form-control','placeholder'=>'--Select the User Organization--']) }}
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">

                    {{Form::label('country', 'User Country')}}

                    <div class="form-group">
                        {{ Form::select('country', $countries,$user->country_id, ['class' => 'form-control','placeholder'=>'--Select the User Country--']) }}
                    </div>

                </div>

                <div class="col-md-6">
                    {{Form::label('department', 'User Department* ')}}
                    <div class="form-group">
                        {{ Form::select('department[]', $departments, $user->department_id, ['class' => 'form-control select2', 'multiple'=>'multiple','placeholder'=>'--Select the User Department--']) }}
                    </div>
                </div>

            </div>
        </div>



        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">UPDATE USER</button>

        </div>

        {{Form::hidden('_method','PUT')}}

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
<script>
    $(function() {
        $(".select2").select2()
    });    
</script>

@stop