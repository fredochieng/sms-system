@extends('adminlte::page')

@section('title', 'Create SMS')

@section('content_header')
    <h1><i class="fa fa-fw fa-envelope "></i> Create SMS/Campaign</h1>
@stop

<style>

.contact_method{ display:none;}

</style>

@section('content')
    <div class="box with-border">
   
              
             <div class="box-body">
             
             <form action="" id="form" method="post">
   Name: <input type="text" name="name">
   Comment: <textarea name="comment"></textarea>
   <input type="submit" value="Submit Comment">
   
    <div>
             
                    	<label for="title">Upload A CSV File </label>
                         <div class="form-group">
                           <input id="uploadImage" type="file" accept="" name="csv_file" class="form-control" />
                        </div>
            	
            </div>  
            
            {!! Form::token() !!}
 </form>
             </div>
    
    
    
     <div class="box-footer">
             sdsd
               
               </div>
               
               
               
       
           
            </div>
            
            </div>
            
            </div>
            
              
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/vendor/adminlte/plugins/iCheck/square/blue.css">
@stop

@section('js')

<script src="/vendor/adminlte/plugins/iCheck/icheck.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" ></script>
  

<script>
     // wait for the DOM to be loaded
    $('#form')
    .ajaxForm({
		  url: "/text/store_text",
        dataType : 'json',
        success : function (response) {
            alert("The server says: " + response);
        }
    })
;
   </script>

  
@stop