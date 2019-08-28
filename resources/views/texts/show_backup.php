@extends('adminlte::page')

@section('title', 'Manage SMS')

@section('content_header')
    <h1><i class="fa fa-fw fa-envelope "></i> {{$text_details->text_title}} Progress</h1>
@stop


@section('content')



   <div class="box with-border">
   <div class="box-body">
   <br>
   
   <div class="col-md-3">
   
   <!--<h4 class="box-title"><i class="fa fa-fw fa-envelope "></i> {{$text_details->text_title}} </h4>-->
   
   <h2>{{count($all_texts)}} <span style="font-size:12px !important"><strong>Contacts</strong></span></h2>
   
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
              <h3>{{count($sent_texts)}}</h3>

              <p>SMS DELIVERED</p>
            </div>
            
            
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{count($queed_texts)}}</h3>

              <p>SMS IN QUE</p>
            </div>
            
            
           
          </div>
        </div>
        
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{count($cancelled_texts)}}</h3>

              <p>SMS UNDELIVERED</p>
            </div>
           
            
          </div>
        </div>
        
       
        
        </div>
        
        <div style="clear:both"></div>
        
         <hr>
        
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#delivered" data-toggle="tab"><i class="fa fa-fw fa-check "></i> DELIVERED SMS</a></li>
              <li><a href="#queed" data-toggle="tab"><i class="fa fa-fw fa-list "></i>  QUEED SMS</a></li>
              <li><a href="#cancelled" data-toggle="tab"><i class="fa fa-fw fa-close "></i>  UNDELIVERED SMS</a></a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="delivered">
                <table  class="table table-bordered table-striped records">
                <thead>
                <tr>
                  <th>Telephone</th>
                  <th>Date / Time Delivered</th>
                  <th>Status</th>
                  <th>Message</th>
                  
                
                </tr>
                </thead>
                <tbody>
                	@if(count($sent_texts) > 0)
                    	@foreach($sent_texts as $sent_text)
                        	<tr>
                            		<td>{{$sent_text->phone_no}}</td>
                                    <td>{{date("d-m-Y",strtotime($sent_text->time_sent))}}  ({{date("h:i:s a",strtotime($sent_text->time_sent))}})</td>
                                    <td><span class="label label-success">DELIVERED</span></td>
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
               <div class="col-md-6" style="padding-left:0px"> <p><strong> Message Delivered To : </strong> <br>{{$sent_text->phone_no}}  </p></div>
                  <div class="col-md-6"> <p><strong> Time Delivered  : </strong> <br>{{date("d-m-Y",strtotime($sent_text->time_sent))}}  ({{date("h:i:s a",strtotime($sent_text->time_sent))}})  </p></div>
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
              <!-- /.tab-pane -->
              <div class="tab-pane" id="queed">
               <table  class="table table-bordered table-striped records">
                <thead>
                <tr>
                  <th>Telephone</th>
                <!--  <th>Date / Time Delivered</th>-->
                  <th>Status</th>
                  <th>Message</th>
                  
                
                </tr>
                </thead>
                <tbody>
                	@if(count($queed_texts) > 0)
                    	@foreach($queed_texts as $queed_text)
                        	<tr>
                            		<td>{{$queed_text->phone_no}}</td>
                                  <!--  <td>{{date("d-m-Y",strtotime($queed_text->time_sent))}}  ({{date("h:i:s a",strtotime($queed_text->time_sent))}})</td>-->
                                    <td><span class="label label-warning">QUEED</span></td>
                                    
                                    <td>
                                     <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#modal-default-{{$queed_text->que_id}}">
               <i class="fa fa-fw fa-envelope "></i> VIEW MESSAGE
              </button>
              
              <div class="modal fade" id="modal-default-{{$queed_text->que_id}}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Message ({{$queed_text->phone_no}})</h4>
              </div>
              <div class="modal-body">
               <div class="col-md-6" style="padding-left:0px"> <p><strong> Phone Number : </strong> <br>{{$queed_text->phone_no}}  </p></div>
                  <div class="col-md-6"></div>
                  <div style="clear:both"></div>
                  <div style="col-md-12">
                  <p><strong>Message : </strong><br>
                  {{$queed_text->message}}
                  
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
              <!-- /.tab-pane -->
              <div class="tab-pane" id="cancelled">
               <table  class="table table-bordered table-striped records">
                <thead>
                <tr>
                  <th>Telephone</th>
                  <th>Date / Time</th>
                  <th>Status</th>
                  <th>Message</th>
                  
                
                </tr>
                </thead>
                <tbody>
                	@if(count($cancelled_texts) > 0)
                    	@foreach($cancelled_texts as $cancelled_text)
                        	<tr>
                            		<td>{{$cancelled_text->phone_no}}</td>
                                    <td>{{date("d-m-Y",strtotime($cancelled_text->time_sent))}}  ({{date("h:i:s a",strtotime($cancelled_text->time_sent))}})</td>
                                    <td><span class="label label-danger">UNDELIVERED</span></td>
                                    
                                  
                                    
                                    <td>
                                    <!-- <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#modal-default-{{$queed_text->que_id}}">
               <i class="fa fa-fw fa-envelope "></i> VIEW MESSAGE
              </button>
              
              <div class="modal fade" id="modal-default-{{$queed_text->que_id}}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Message ({{$queed_text->phone_no}})</h4>
              </div>
              <div class="modal-body">
               <div class="col-md-6" style="padding-left:0px"> <p><strong> Phone Number : </strong> <br>{{$queed_text->phone_no}}  </p></div>
                  <div class="col-md-6"></div>
                  <div style="clear:both"></div>
                  <div style="col-md-12">
                  <p><strong>Message : </strong><br>
                  {{$queed_text->message}}
                  
                  </p>
                  </div>
                  <div style="clear:both"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat pull-left" data-dismiss="modal">Close</button>
             
              </div>
            </div>
           
          </div>
         
        </div>-->
                                    
                                    </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                   
                            
                            </tr>
                        
                        
                        @endforeach
                
                	@else
                    
                    @endif
                
                </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
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