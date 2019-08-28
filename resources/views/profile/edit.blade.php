@extends('adminlte::page')

@section('title', 'Manage SMS')

@section('content_header')
    <h1><i class="fa fa-fw fa-lock"></i> Edit Profile</h1>
@stop


@section('content')

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   
   <div class="col-md-4">
     {!! Form::open(['action'=>'ProfileController@edit','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
     
     <br>
      <div class="col-md-12">
                  
               			  {{Form::label('email', 'Your Email / Username')}}
                
                         <div class="form-group">
                             {{Form::text('email', $email,['class'=>'form-control','placeholder'=>'','readonly'=>'true'])}}
                        </div>
                 
                    
                    </div>
                    
                    
                    <div class="col-md-12">
                  
               			  {{Form::label('password', 'Your New Password')}}
                
                         <div class="form-group">
                                {{Form::password('password',['class'=>'form-control','placeholder'=>'Enter Password'])}}
                        </div>
                 
                    
                    </div>
                    
                     <div class="col-md-12">
                  
               			  {{Form::label('password_confirmation', 'Retype New Password')}}
                
                         <div class="form-group">
                                {{Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Re-Enter Password'])}}
                        </div>
                 
                    
                    </div>
                    
                     <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-flat" name="save">SAVE CHANGES</button>
                    
                    </div>
     
     
     {!! Form::close() !!}
   
   </div>
   
   <div style="clear:both"></div>		 
   </div>
   </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
     <script>
	// $("#records").DataTable();
	
	 $('#records').DataTable({
    "ordering": false
});
	
	 </script>
@stop