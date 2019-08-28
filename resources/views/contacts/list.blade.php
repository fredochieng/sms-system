@extends('adminlte::page')

@section('title', 'Manage  Contacts Lists')

@section('content_header')
    <h1><i class="fa fa-fw fa-phone "></i> Manage Contacts Lists</h1>
@stop

<style>

.floatit{ float:right; margin-bottom:0px !important}
</style>

@section('content')
   <div class="box with-border">
   <div class="box-body">
   

   		 <table id="records" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                  <th>Title</th>
                  <th>Date Created</th>
                  
                   <th>Contact type</th>
                  <th>View Contacts</th>
                  <th>Actions</th>
                
                </tr>
                </thead>
                <tbody>
                
                
                   @if(count($contacts)>0)
                   
                   		@foreach($contacts as $key=>$contacts)
                   			
                            <tr>
                            <td>{{$key+1}}</td>
                            	<td>{{$contacts->contacts_title}}</td>
                                <td>{{date("d-m-Y",strtotime($contacts->created_at))}}</td>
                                
                                <td>
                                	@if($contacts->contacts_from=='csv')
                                    
                                   			<i class="fa fa-fw fa-file"></i> CSV File 
                                    @elseif($contacts->contacts_from=='phone_book')
                                    		<i class="fa fa-fw fa-book"></i>	Phone Book
                                  
                                    
                                    @endif
                                
                                
                                
                                </td>
                            	
                                <td>
                                	@if($contacts->contacts_from=='csv')
                                     
                                   			<a href="/{{$contacts->csv_file}}"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                                    @elseif($contacts->contacts_from=='phone_book')
                                    		<a href="{{url('/')}}/contact/{{$contacts->contacts_id}}"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                                  
                                    
                                    @endif
                                
                                
                                
                                </td>
                                <td>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                             
          
          
           <a href="/contact/{{$contacts->contacts_id}}/edit" class="btn btn-warning btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
       <strong>  <i class="fa fa-edit"></i></strong>
          </a>
          
          
          
                <!--<form action="{{ route('contact.destroy', $contacts->contacts_id) }}" method="post" style="float:right">-->
                
                 {!! Form::open(['action'=>['ContactController@destroy',$contacts->contacts_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data']) !!}  
          
            {{ csrf_field() }}
           {{Form::hidden('_method','DELETE')}}
           
            <button type="submit" class="btn btn-danger btn-xs btn-flat"  onClick="return confirm('Are you sure you want to delete this contact? All the Text messages associated with it will also be deleted. Click OK to Continue');">   <strong>  <i class="fa fa-close"></i></strong></button>
          
        
          
          </form>
                    
                                
                                
                                
                                
                                
                                
                                </td>
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