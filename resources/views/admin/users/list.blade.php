@extends('adminlte::page')

@section('title', 'Manage Users')

@section('content_header')
<h1><i class="fa fa-fw fa-users"></i> Users</h1>
@stop

<style>
  .floatit {
    display: inline;
    margin: 0px !important
  }
</style>

@section('content')

<div class="box">

  <div class="box-header with-border">
    <h5 class="box-title">Mananage Users</h5>

  </div>

  <div class="box-body">

    <table id="records" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Full Names</th>
          <th>Email</th>
          <th>Role</th>
          <th>Organization</th>
          <th>Country</th>
          <th>Department</th>
          <th>Date Created</th>
          <th>Actions</th>


        </tr>
      </thead>
      <tbody>
        @if($users->count()>0)
        @foreach($users as $user)
        <tr>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->role}}</td>
          <td>{{$user->organization}}</td>
          <td>{{$user->country}}</td>
          <td>{{$user->department}}</td>
          <td>{{date("d-m-Y",strtotime($user->created_at))}} ({{date("h:i:s a",strtotime($user->created_at))}})</td>
          <td>


            <a href="{{url('/')}}/admin/user/{{$user->id}}/edit" class="btn btn-warning btn-sm btn-flat btn-xs"
              data-toggle="tooltip" title="Edit">
              <strong> <i class="fa fa-edit"></i></strong>
            </a>



            @if($current_user!=$user->id)

            {!!
            Form::open(['action'=>['Admin\\UserController@destroy',$user->id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}


            {{Form::hidden('_method','DELETE')}}

            <button type="submit" class="btn btn-danger btn-xs btn-flat"
              onClick="return confirm('Are you sure you want to delete this User?');"> <strong> <i
                  class="fa fa-close"></i></strong></button>



            {!! Form::close() !!}

            @endif

          </td>

        </tr>
        @endforeach
        @endif
      </tbody>

    </table>



  </div>

  <div class="box-footer">

  </div>



</div>








@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop

@section('js')
<script>
  $('#records').DataTable({
    "ordering": false
});
</script>

@stop