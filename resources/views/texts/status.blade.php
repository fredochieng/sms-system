@extends('adminlte::page')

@section('title', 'SMS Status')

@section('content_header')
    <h1><i class="fa fa-fw fa-envelope "></i> {{$text_details->text_title}} ({{$status}} SMS)</h1>
@stop


@section('content')



   <div class="box with-border">
   <div class="box-body">
   <br>
   
   <div class="col-md-3">
   
   <!--<h4 class="box-title"><i class="fa fa-fw fa-envelope "></i> {{$text_details->text_title}} </h4>-->
   
   <h2>{{number_format(count($all_texts))}} <span style="font-size:12px !important"><strong>Contacts</strong></span></h2>
   
   <div class="clearfix">
                    <span class="pull-left">Overall Progress</span>
                    <small class="pull-right">{{$percentage_progress}} %</small>
                  </div>
   <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: {{$percentage_progress}}%;"></div>
                  </div>
   
   </div>
   
    <div class="col-md-9">
   		<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{number_format($sent_texts->count())}}</h3>

              <p>SMS DELIVERED</p>
            </div>
            <a href="{{url('/')}}/text/{{$text_details->text_id}}/delivered/status" class="small-box-footer">View Delivered SMS <i class="fa fa-arrow-circle-right"></i></a>
            
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{number_format($queed_texts->count())}}</h3>

              <p>SMS IN QUE</p>
            </div>
            
             <a href="{{url('/')}}/text/{{$text_details->text_id}}/queed/status" class="small-box-footer">View  SMS in Quee <i class="fa fa-arrow-circle-right"></i></a>
           
          </div>
          
        </div>
        
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{number_format($cancelled_texts->count())}}</h3>

              <p>SMS UNDELIVERED</p>
            </div>
           
             <a href="{{url('/')}}/text/{{$text_details->text_id}}/undelivered/status" class="small-box-footer">View Undelivered SMS <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
       
        
        </div>
        
        <div style="clear:both"></div>
        <hr>
         <a href="{{url('/')}}/text/{{$text_details->text_id}}" class="btn btn-default btn-sm btn-flat"><strong>SHOW  IMPORT OPTIONS</strong></a>
         
         <hr>
        
        <table  class="table table-bordered table-striped records">
                <thead>
                <tr>
                  <th>Telephone</th>
                  <th>@if($status=='delivered')
                                    
                                    	Date/Time Delivered
                                    
                                    	@elseif($status=='queed')
                                       
                                        Date/Time Queed
                                        
                                        @else
                                         Date/Time 
                                        @endif</th>
                  <th>Status</th>
                  <th>Message</th>
                  
                
                </tr>
                </thead>
                <tbody>
                	@if(count($sms_data) > 0)
                    	@foreach($sms_data as $sent_text)
                        	<tr>
                            		<td>{{$sent_text->phone_no}}</td>
                                    <td>
                                    	@if($status=='delivered')
                                    
                                    	{{date("d-m-Y",strtotime($sent_text->time_sent))}}  ({{date("h:i:s a",strtotime($sent_text->time_sent))}})
                                    
                                    	@elseif($status=='queed')
                                       
                                        {{date("d-m-Y",strtotime($sent_text->created_at))}}  ({{date("h:i:s a",strtotime($sent_text->created_at))}})
                                        
                                        @endif
                                        
                                        
                                    
                                    </td>
                                    
                                    
                                    
                                    <td>
                                    
                                    @if($status=='delivered')
                                    
                                    	  <span class="label label-success">DELIVERED</span>
                                    
                                    	@elseif($status=='queed')
                                       
                                          <span class="label label-warning">QUEED</span>
                                          
                                        @elseif($status=='undelivered')
                                          <span class="label label-danger">UNDELIVERED</span>
                                        @endif
                                    
                                    
                                    
                                    
                                    
                                    
                                  </td>
                                     <td>
                 <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#modal-default-{{$sent_text->que_id}}">
               <i class="fa fa-fw fa-envelope "></i> VIEW MESSAGE
              </button>
              
              <div class="modal fade" id="modal-default-{{$sent_text->que_id}}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Message ({{$sent_text->phone_no}})</h4>
              </div>
              <div class="modal-body">
               <div class="col-md-6" style="padding-left:0px"> <p><strong> Telephone : </strong> <br>{{$sent_text->phone_no}}  </p></div>
                  <div class="col-md-6"> <p><strong> Time   : </strong> <br>{{date("d-m-Y",strtotime($sent_text->time_sent))}}  ({{date("h:i:s a",strtotime($sent_text->time_sent))}})  </p></div>
                  <div style="clear:both"></div>
                  <div style="col-md-12">
                  <p><strong>Message : </strong><br>
                  {{$sent_text->message}}
                  
                  </p>
                  </div>
                  <div style="clear:both"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat pull-left" data-dismiss="modal">Close</button>
               <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                                     
                                     </td>
                            
                            </tr>
                        
                        
                        @endforeach
                
                	@else
                    
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
	// $("#records").DataTable();
	
	 $('.records').DataTable({
    "ordering": false
});
	
	 </script>
@stop