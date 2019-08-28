 {!! Form::open(['action'=>'TextController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
            
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Import Contacts from a CSV file</h4>
              </div>
              <div class="modal-body">
               
               <div class="row">
               
                <div class="importing_errors col-md-12" style="color:#F90004">
                Please upload a 
                </div>
               <div class="col-md-12">
                    	{{Form::label('import_file', 'Upload CSV File')}}
                         <div class="form-group">
                             {{Form::file('import_file',['class'=>'form-control'])}}
                        </div>
                        
                     
            	   </div>
                   
                    <div class="col-md-12">
                    	
                         <div class="form-group">
                             {{ Form::checkbox('save_for_future_switch',null,null, array('id'=>'save_for_future_switch')) }} {{Form::label('save_for_future_switch', ' Save The imported contacts for future use')}}
                        </div>
                        
                        
                        
                        <div class="upload_csv_title_wrapper">
                    	{{Form::label('csv_upload_title', 'Enter Title for the contacts')}}
                         <div class="form-group">
                             {{Form::text('csv_upload_title', '',['class'=>'form-control'])}}
                        </div>
                        
                     
            	   </div>
                        
                        
                        
                     
            	   </div>
               
               
              
               </div>
               
               </div>
               
                <div class="modal-footer">
                <button type="button" class="btn btn-info pull-left btn-flat import_submit">IMPORT CONTACTS</button>
                
                <div style="importing_status">
                
                </div>
              
              </div>
             {!! Form::close() !!}