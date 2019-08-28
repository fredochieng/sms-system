@extends('adminlte::page')

@section('title', 'Manage SMS')

@section('content_header')
    <h1><i class="fa fa-fw fa-envelope "></i> Manage SMS</h1>
@stop


@section('content')

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   
   <p style="padding:15px; text-align:center"><span class="label label-success">SENT</span> status indicate the text send process has started. Click on the view button to check the Entire Progress </p>
   		 <table class="table table-bordered table-striped">  
                <thead>
                <tr>
                  <th style="width:30%">Title</th>
                  <th>Date / Time Created</th>
                  <th>Status</th>
                  <th>Recepient Contacts(s)</th>
                 
                  @if(isset($_GET['status_only'])&& $_GET['status_only']=='yes')
                        
                        
                        @else
                 
                 
                  <th></th>
                  
                  
                  @endif
                
                </tr>
                </thead>
                <tbody>
                
                  @if(count($texts)>0)
                  
                  
       
                   
                   		@foreach($texts as $key=>$text)
                       
                        <tr>
                	<td>
                    
                      @if($text->qued >= 2)
                        <a href="{{url('/')}}/text/{{$text->text_id}}"><strong>{{$text->text_title}}</strong></a>
                      @else
                       <strong>{{$text->text_title}}</strong>
                      @endif   
                      
                     <br> <span style="font-size:11px">By : {{$text->created_by_name}}</span>                  
                  </td>
                    <td>{{date("d-m-Y",strtotime($text->created_date))}}  ({{date("h:i:s a",strtotime($text->created_date))}})</td>
                  
                      
                        <td>
                        
                        
                         @if($text->qued ==2)
                       
                       <a href="{{url('/')}}/text/{{$text->text_id}}">
                      

<span class="label label-success">SENT</span>

</a>  
                         @elseif($text->qued==3 && $text->status !='canceled')
                        <a href="{{url('/')}}/text/{{$text->text_id}}">
                        	<span class="label label-warning">QUEED</span>
                            </a>
                             
                             @elseif($text->status=='draft')
                             
                              <span class="label label-default">DRAFT</span>
                              
                              @elseif($text->status=='canceled')
                               <span class="label label-warning">CANCELED</span>
                              
                      	
                         
                         @elseif($text->status=='pending_approval')
                               <span class="label label-default">PENDING APPROVAL</span>
                               
                               @can('approve text')
                               
  							  <a href="{{url('/')}}/text/approvetext/approve/{{$text->text_id}}">
                        	 <span class="label label-info"><i class="fa fa-check"></i> APPROVE</span>
                            </a>
@endcan
                              
                      	 @else
                         
                            <span class="label label-default">PROCESSING</span>
                            
                         @endif
                        
                        
                        </td>
                        
                        
                          <td>
                        
                        @if($text->contacts_id > 0)
                        
                        	@if($text->contacts_from=="csv")
                             	<a href="/{{$text->csv_file}}"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                        
                             @elseif($text->contacts_from="phone_book")
                            	 <a href="{{url('/')}}/contact/{{$text->contacts_id}}"><strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                            @endif
                            
                          @else
                          
                          <a href="#contacts-modal{{$text->text_id}}" data-toggle="modal" data-target="#contacts-modal{{$text->text_id}}">
                          <strong><i class="fa fa-fw fa-eye "></i> View Contacts</strong></a>
                          	@include('texts._recepients_contacts_modal')
                          
                          @endif
                          
                          
                        
                        </td>
                        
                        
                        @if(isset($_GET['status_only'])&& $_GET['status_only']=='yes')
                        
                        
                        @else
                        
                        <td>
                        
                           @if($text->status  != 2)
                           		<?php $action_text="View"; $btn_color="info"; ?>
                              
                  <a href="{{url('/')}}/text/{{$text->text_id}}" class="btn btn-{{$btn_color}} btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
                                               
       <strong>  <i class="fa fa-file"></i> {{$action_text}}</strong>
          </a> &nbsp;
                              @else
                              
                              <?php $action_text="Edit"; $btn_color="warning";?>
                                
                                <a href="{{url('/')}}/text/{{$text->text_id}}/edit" class="btn btn-{{$btn_color}} btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit">
                              
                            @endif
       
          
         
          
           <a href="{{url('/')}}/text/action_text/{{$text->text_id}}/cancel/" class="btn btn-default btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit" 
           onclick="return confirm('Are you sure you want to Cancel this text?');"
           >
       <strong>  <i class="fa fa-close"></i> Cancel</strong>
          </a>&nbsp;
          
          {{-- <a href="{{url('/')}}/text/action_text/{{$text->text_id}}/delete/" class="btn btn-danger btn-sm btn-flat btn-xs" data-toggle="tooltip" title="Edit"
          
            onclick="return confirm('Are you sure you want to Delete this text?');"
          >
       <strong>  <i class="fa fa-bin"></i> Delete</strong>
          </a> --}}
                        
                        </td>
                        
                        @endif
                       
                
                </tr>
                   			
                        @endforeach
                   @endif
                
                
                </tbody>
                </table>
                
                
                  {{ $texts->links() }}
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