@extends('adminlte::page')

@section('title', 'Manage  Contacts Lists')

@section('content_header')
    <h1><i class="fa fa-fw fa-phone "></i> {{$contact->contacts_title}} Contacts </h1>
@stop

@section('content')
   <div class="box with-border">
   <div class="box-body">
   

   		 <table id="records" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Telephone </th>
                  <th>Email</th>
                
                </tr>
                </thead>
                
                <tbody>
                
                <?php $contacts_array = (array) json_decode($contact->phone_book_contacts);?>
                
       
                
                  @if(count($contacts_array)>0)
                   
                   		@foreach($contacts_array as $key=>$contacts)
                   			
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$contacts->first_name}}</td>
                                <td>{{$contacts->last_name}}</td>
                                <td>{{$contacts->phone}}</td>
                                 <td>{{$contacts->email}}</td>
                            </tr>
                            
                          @endforeach
                          
                   @endif
                
                
                
                
                
                
                </tbody>
           
                </table>
   </div>
   </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
     <script>
	 $("#records").DataTable();
	
	 </script>
@stop