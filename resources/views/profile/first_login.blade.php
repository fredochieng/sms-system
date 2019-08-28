

<br>
   <div class="box with-border">
   <div class="box-body">
   
   
   <div class="alert alert-warning"><strong>RESET PASSWORD:</strong> <br>For Security Reasons your are required to reset the default password. Enter your new password to continue. </div>
   
   
   @if(count($errors)>0)
    <div class="alert alert-danger alert-dismissible">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach($errors->all() as $error)
            {{$error}}<br>
        @endforeach
     </div>
@endif
   <div class="col-md-4">
     {!! Form::open(['action'=>'ProfileController@first_time_reset','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
     
     <br>
      <div class="col-md-12">
                  
               			  {{Form::label('email', 'Your Email / Username')}}
                
                         <div class="form-group">
                             {{Form::text('email', $user_first_login->email,['class'=>'form-control','placeholder'=>'','readonly'=>'true'])}}
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
