@extends('adminlte::page')

@section('title', 'Reports by Campaign')

@section('content_header')
    <h1><i class="fa fa-fw fa-file "></i> Reports by Campaign</h1>
@stop


@section('content')

<style>

.progress-bar {
   
    background-color: #00a65a !important;
}

</style>


   <div class="box with-border">
   <div class="box-body">
   		 <table class="table table-bordered table-striped">  
                <thead>
                <tr>
                  <th style="width:30%">Title</th>
                  <th>Date / Time Created</th>
                 <!-- <th>Status</th>-->
                  <th>Report</th>
                 
                 
                 
                 
               
                  
                
                
                </tr>
                </thead>
                <tbody>
                
                  @if(count($texts)>0)
                   
                   		@foreach($texts as $key=>$text)
                        <tr>
                	<td>
                    
                     
                        <a href="{{url('/')}}/text/{{$text->text_id}}"><strong>{{$text->text_title}}</strong></a>
                    
                      
                     <br> <span style="font-size:11px">By : {{$text->created_by_name}}</span>                  
                  </td>
                    <td>{{date("d-m-Y",strtotime($text->created_at))}}  ({{date("h:i:s a",strtotime($text->created_at))}})</td>
                  
                      
                     <!--   <td>
                        
                        
                       
                       
                       <a href="{{url('/')}}/text/{{$text->text_id}}">
                     

<span class="label label-success">0 % SENT</span>

</a>
                         @if($text->qued==2 && $text->status !='canceled')
                        <a href="{{url('/')}}/text/{{$text->text_id}}">
                        	<span class="label label-warning">QUEED</span>
                            </a>
                            
                             @elseif($text->status=='draft')
                             
                              <span class="label label-default">DRAFT</span>
                              
                              @elseif($text->status=='canceled')
                               <span class="label label-warning">CANCELED</span>
                              
                      	
                         
                         @elseif($text->status=='pending_approval')
                               <span class="label label-default">PENDING APPROVAL</span>
                               
                            
                      	 @else
                         
                            <span class="label label-default">PROCESSING</span>
                            
                         @endif
                        
                        
                        </td>-->
                        
                        <td>
                       <a href="{{url('/')}}/reports/generate_excel/{{$text->text_id}}/all" class="btn btn-info btn-flat btn-xs"><strong> <i class="fa fa-fw fa-download"></i> DOWNLOAD SUMMARY REPORT</strong></a> &nbsp; &nbsp;
                       
                        <a href="{{url('/')}}/text/{{$text->text_id}}" class="btn btn-primary btn-flat btn-xs"><strong> <i class="fa fa-fw fa-file "></i> VIEW DETAILED REPORT</strong></a>
                        
                        </td>
                        
                        
                       
                        
                        
                      
                
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