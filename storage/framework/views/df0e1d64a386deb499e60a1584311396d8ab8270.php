

<?php $__env->startSection('title', 'Create SMS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-envelope "></i> Create SMS/Campaign</h1>
<?php $__env->stopSection(); ?>

<style>

.contact_method{ display:none;}
.counting{font-size:18px; padding-top:10px}
.remain{font-weight:bold}
.red{ color:#ef1616}

</style>

<?php $__env->startSection('content'); ?>
 <div class="alert alert-danger inline_errors" style="display:none"></div>
    <div class="box with-border">
   
               <?php echo Form::open(['action'=>'TextController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

              <div class="box-body">
              
             
              		
                        <div class="row">
                  	<div class="col-md-12">
                    	<?php echo e(Form::label('title', 'Title of your SMS / Campaign* ')); ?>

                         <div class="form-group">
                             <?php echo e(Form::text('title', '',['class'=>'form-control', 'placeholder'=>'Enter your Sms/Campaign Title', 'required'=>'required'])); ?>

                        </div>
            	   </div>
                   </div>
                     
                    <div class="row">
                    <div style="clear:both"></div>
                    <div class="col-md-4">
                    
                     <?php echo e(Form::label('recepients_country', 'Select Recepients Country *')); ?> 
                
                         <div class="form-group">
                             <?php echo e(Form::select('recepients_country', $countries,null, ['class' => 'form-control','placeholder'=>'--Select the country you are sending SMS to--'])); ?>

                        </div>
                    </div>
                   
                    </div>
                    
                        <br>
                   
                   
                       <div class="row">
                       
                     
                         <div class="col-md-12">
                      <h4>Select Contacts Source</h4>
                      
                      </div>
                       
                        <div class="col-md-3">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="contact_list"> 
                  <i class="fa fa-fw fa-list "></i>From a Saved Contact List
                </label>
                
                </div>
                
                <div class="col-md-3">
                
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="csv_upload">
                <i class="fa fa-fw fa-file "></i> Import from a CSV/Excel File
                </label>
                
               </div>
               
               
                <div class="col-md-3">
                
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="recepient_contacts">
                <i class="fa fa-fw fa-phone "></i> Enter Recipient Contacts
                </label>
                
               </div>
                
                       </div>
                       <br>
                   
                   
                   
                      <div class="row">
                  	<div class="col-md-12 contact_method contact_list">
                    	<?php echo e(Form::label('recepients_contact_list', 'Recepients From a  Contact List')); ?>

                         <div class="form-group">
                             
                             
                             <select class="form-control select2 contact_list_sel " multiple  data-placeholder="Select a Contact"
                        style="width: 100%;" name="contact_list[]">
                 
                 <?php if(count($contacts)>0){ 
				 	foreach($contacts as $contact) {
				 
				 ?>
                 
                 
                 
                  <option value="<?php echo $contact->contacts_id?>"><?php echo $contact->contacts_title?></option>
                  
                  <?php } ?>
                 
                 
                 <?php } ?>
                </select>
                        </div>
                        
               
            	   </div>
                   
                   
                   
                   
                   
                   
                    	<div class="col-md-12 contact_method csv_upload">
                        
          <button type="button" class="btn btn-info btn-sm btn-flat upload_csv_btn" data-toggle="modal" data-target="#modal-upload-csv"><strong><i class="fa fa-fw fa-upload"></i>UPLOAD CONTACTS FROM A CSV FILE</strong>
              </button>
            <h4 class="uploaded_user_csv_contact" style="display:none">
            
            
            <span class="uploaded_csv_name"></span>
           <a href="" class="remove_uploaded_csv"> <span style="color:#E41114"><i class="fa fa-fw fa-close"></i></span></a>
            
         
            
            </h4>
                       
            	   </div>
    
                   
                   <div class="col-md-12 contact_method recepient_contacts">
                    	<?php echo e(Form::label('recepients_phone_nos', 'Recepients Phone Numbers with Country Code (Comma separated)')); ?>

                         <div class="form-group">
                             <?php echo e(Form::textarea('recepients_phone_nos', '',['class'=>'form-control recepient_contacts', 'placeholder'=>'Comma separated Phone numbers e.g: 254713295853, 254123459789, 254987654321 '])); ?>

                        </div>
                        
                      
                        <div style="clear:both"></div>
            	   </div>
                   
                 
                   </div>
                   
                   <div style="clear:both"></div>
                   
                    <div class="row" style="padding-top:20px">
                   
                    
                      
                   
                  	<div class="col-md-12">
                     <span style="float:right; margin-right:100px; display:none" class="shortcodes">
                    <div class="btn-group">
                  <button type="button" class="btn  btn-flat btn-info dropdown-toggle btn-sm" data-toggle="dropdown"><strong>{&nbsp; }</strong></button>
                
                  <ul class="dropdown-menu shortcodes_ul" role="menu" style="padding: 0px 0; height:250px; overflow:auto">
    
                  
                  </ul>
                </div>
                    </span>
                  
                    
                    <div style="clear:both"></div>
                  
                    
                    	<?php echo e(Form::label('messageBody', 'Your message')); ?>

                         <div class="form-group">
                             <?php echo e(Form::textarea('messageBody', '',['class'=>'form-control', 'placeholder'=>'Enter your Sms/Campaign Title'])); ?>

                             
                              <p class="counting"> <span class="remain">350</span> characters remaining</p>
                        </div>
                        
                     
            	   </div>
                   
                 <!--  <div class="col-md-12">
                   <input type="button" value="<<Account No>>" onclick="insertAtCaret('messageBody','<<Account No>>');" />
                   <input type="button" value="<<FirstName>>" onclick="insertAtCaret('messageBody','<<FirstName>>');" />
                  <input type="button" value="<<LastName>>" onclick="insertAtCaret('messageBody','<<LastName>>');" />
               
                   </div>
                   -->
                  
                   </div>
                    
               
             

              
              
    </div>
    
    
    
     <div class="box-footer">
          
                
                
              
                <button  class="btn btn-info btn-flat preview"><strong><i class="fa fa-fw fa-tv"></i> VALIDATE & PREVIEW SMS</strong></button> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                
                  <span class="submit_buttons">
                      <button type="submit" class="btn btn-success btn-flat save"><strong><i class="fa fa-fw fa-share-square"></i> SUBMIT SMS</strong></button> &nbsp;
               
                
                 
                <!-- <button type="submit" class="btn btn-default btn-flat save_draft" name="save_draft"><i class="fa fa-fw fa-save"></i> SAVE DRAFT</button>-->
            
             </span>
            
              </div>
              
              
                 <input type="hidden" class="send_contact_id" name="send_contact_id">
                  <input type="hidden"  name="text_id" value="0">
              
               <?php echo Form::close(); ?>

               
               </div>
               
               
               
        <div class="modal fade" id="modal-upload-csv">
          <div class="modal-dialog">
            <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Import Contacts from a CSV file</h4>
              </div>
              
              
                <div class="modal-body">
                
                 <p class="importing_errors" style="color:#F90004; font-weight:bold">    </p>
            
            <form id="form" action="" method="post" enctype="multipart/form-data">
            
            
            <div>
             
                    	<label for="title">Upload A CSV File </label>
                         <div class="form-group">
                           <input id="uploadImage" type="file" accept="" name="csv_file" class="form-control" />
                        </div>
            	
            </div>  
            
            
           <div class="col-md-12">
                    	
                         <div class="form-group">
                             <?php echo e(Form::checkbox('save_for_future_switch',null,null, array('id'=>'save_for_future_switch'))); ?> <?php echo e(Form::label('save_for_future_switch', ' Save The imported contacts for future use')); ?>

                        </div>
                        
                        
                        
                        <div class="upload_csv_title_wrapper">
                    	<?php echo e(Form::label('csv_upload_title', 'Enter Title for the contacts')); ?>

                         <div class="form-group">
                             <?php echo e(Form::text('csv_upload_title', '',['class'=>'form-control'])); ?>

                        </div>
                        
                     
            	   </div>
                        
                        
                        
                     
            	   </div>
              





<input class="btn btn-info btn-flat csv_upload" type="submit" value="IMPORT CONTACTS">

<p class="uploading_csv_alert" style="display:none">Uploading CSV Please Wait...</p>
 <input type="hidden" name="contact_id" value="0">
<?php echo Form::token(); ?>

</form>
 
<div id="err"></div>

</div>
</div>
</div>
</div>





 <div class="modal fade" id="preview_sms">
 
 
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> PREVIEW SMS</h4>
              </div>
              
              
                <div class="modal-body">
   
                
                  <div class="sms_preview_loading_cover" style="display:none">
                  	<h5>Loading SMS Preview...Please Wait</h5>
                  </div>
                
                
                <div class="sms_preview_cover row" style="display:none">
                
               
               
               
                <div class="col-md-6">
              
                
                <div class="well" style="padding:12px;background-color: #e7f6ff;
    border: 1px solid #e7f6ff;">
                <p style="font-size:16px !important; margin:0 !important" class="message_well">
               
                
                </p>
                </div>
                
                <h5><strong>TOTAL SMS CONTACTS: <br><span class="total_contacts" style="font-size:23px"></span> </strong> </h5>
                </div>
                
                
                
                <div class="col-md-6">
                <table class="table table-striped table-bordered">
                
                
                	
                    
                     <tr>
                    	<td >VALID CONTACTS</td>
                        <td class="valid_contacts" style="font-weight:bold; color:#007310"></td>
                    
                    </tr>
                   <!-- <tr>
                    	<td>DUPLICATE CONTACTS</td>
                        <td>1</td>
                    
                    </tr>-->
                    
                      <tr>
                    	<td>INVALID CONTACTS</td>
                        <td  class="invalid_contacts" style="font-weight:bold; color:red"></td>
                    
                    </tr>
                    
                    
                     <tr>
                    	<td>TOTAL CONTACTS</td>
                        <td  class="total_contacts" style="font-weight:bold;" ></td>
                    
                    </tr>
                    
                    <tr>
                    	<td style="width:70%">TOTAL MSG. CHARACTERS</td>
                        <td class="total_msg" style="font-weight:bold;"></td>
                    
                    </tr>
                    
                    <tr>
                    	<td style="width:70%">RECEPIENTS COUNTRY</td>
                        <td class="recipient_country_td" style="font-weight:bold;"></td>
                    
                    </tr>
                    
                    
                
                </table>
                
                </div>
                
                <div style="clear:both"></div>
                  
                  
                  
                  <div class="col-md-12"><p style="font-size:13px">Click on <strong>LOOK'S GOOD</strong> to close the preview screen then click on <strong>SUBMIT SMS</strong> button to Send.</p></div>  
                
             </div> 
           
         
  

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary btn-flat pull-left looks_good"> <strong>LOOK'S GOOD</strong></button>

<button type="button" class="btn  btn-flat close_preview"  data-dismiss="modal"> CLOSE PREVIEW</button>
               
              </div>
</div>
</div>

 
</div>



           
            </div>
            
            </div>
            
            </div>
            
              
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/vendor/adminlte/plugins/iCheck/square/blue.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="/vendor/adminlte/plugins/iCheck/icheck.min.js"></script>

   <script>
   
   function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

  $(".close_preview").hide();
	$(".looks_good").hide();
	$(".submit_buttons").hide();
   $(document).ready(function() {
	   
	   
	 
	
	
	
	
	$(".looks_good").click(function(e){
        e.preventDefault();
		 $('#preview_sms').modal('toggle');
		 	 $([document.documentElement, document.body]).animate({
       			 scrollTop: $(".looks_good").offset().top
    		}, 4000);
			
			$(".submit_buttons").show();
		
    }); 
	
	
	   
 $(".preview").click(function(e){
	$(".submit_buttons").hide();		
 $(".close_preview").hide();
	$(".looks_good").hide();
			
	var error_dis="no";
				var errors='<p><strong>CORRECT THE ERRORS BELOW TO CONTINUE</strong></p>';
	
	$(".sms_preview_cover").hide(); 
	

	$(".sms_preview_loading_cover").show();
	
	
	
	 contact_source= $('input[name=contact_source]:checked').val();
	 message= $('#messageBody').val();
	 
	 
	 if(contact_source=="contact_list"){
		 contacts= $('.contact_list_sel').val();	 
	 }
	 
	 if(contact_source=="csv_upload"){
		 contacts= $(".send_contact_id").val();	 
	 }
	 
	  if(contact_source=="recepient_contacts"){
		 contacts= $("#recepients_phone_nos").val();	 
	 }
      	 	e.preventDefault();
				
	   		  if( !$("#title").val() ) {
				 error_dis="yes";
				 errors=errors + "<p>Provide a Title for your Campaign</p>";
   				}
				
				
				
				
				
				
				 sel_contact_source= $('input[name=contact_source]:checked').val();
				 
				
				
				if(sel_contact_source==null){
					 error_dis="yes";
					 errors=errors + "<p>Select the sms Contact Source</p>";
				}else{
					 if(sel_contact_source=="contact_list"){
							 contacts= $('.contact_list_sel').val();
							 if(contacts==''){
								  error_dis="yes";
								 errors=errors + "<p>Select Contacts From Recepients Contact List</p>";
							}
					 }
					 
					 
					 
					
					 if(sel_contact_source=="csv_upload"){
							 if($(".send_contact_id").val()==''){
								  error_dis="yes";
								 errors=errors + "<p>Upload CSV Contact File</p>";
							}
					 }
					 
					 
					  if(sel_contact_source=="recepient_contacts"){
							 if($("#recepients_phone_nos").val()==''){
								  error_dis="yes";
								 errors=errors + "<p>Enter a Separated Comma list of the Recepient Phone Numbers</p>";
							}
					 }
					
				}
				
				
				if( !$("#recepients_country").val() ) {
					 error_dis="yes";
					 errors=errors + "<p>Select Recipients Country</p>";
   				}
				
				
				if( !$("#messageBody").val() ) {
					 error_dis="yes";
					 errors=errors + "<p>Enter  SMS message</p>";
   				}
				
				

				if(error_dis=='yes'){ 
				  $(".inline_errors").html(errors)
         			$(".inline_errors").show()
				}else{
					recipient_country=$("#recepients_country").val()
					//alert(recipient_country);
					//$.get('http://62.8.88.218:98/index.php/text/sms_preview',
					$.get('/index.php/text/sms_preview', { contacts: contacts,contact_source:contact_source,message:message,recipient_country:recipient_country }, function (data) {  
					    			
						 var response=jQuery.parseJSON(data);
						
						if(typeof response =='object'){
							data = JSON.parse(data);
							
							$(".sms_preview_loading_cover").hide();
							$(".sms_preview_cover").show();
							
							
							$(".message_well").html(data.final_preview_message);
							$(".recipient_country_td").html(data.recepient_country);
							$(".total_contacts").html(addCommas(data.total_contacts));
							$(".total_msg").html(addCommas(data.message_length));
							$(".valid_contacts").html(addCommas(data.valid_contacts));
							$(".invalid_contacts").html(addCommas(data.invalid_contacts));
							
							$(".close_preview").show();
							$(".looks_good").show();
							
							
						}
						
						
       				 });
			
						$(".inline_errors").hide()
						$('#preview_sms').modal({show:'show',backdrop: 'static',
    keyboard: false});
	
	
	
					
				}
				
				
   		 }); 
	   
	   
	   
	      $('.form').submit(function(){
    $(".save", this)
      .text("PROCESSING... PLEASE WAIT")
      .attr('disabled', 'disabled');
	  
	  
	 $(".save_draft", this)
      //.val("Please Wait...")
      .attr('disabled', 'disabled');
	  
	  
	  
	  
    return true;
  });
	   
	   
	   
	   $('.contact_list_sel').on('change', function() {
		   $(".shortcodes_ul").empty();
		   $(".shortcodes").show();
 			var contacts_id=this.value;
			if(contacts_id){
				
					
					$.get('/index.php/text/check_selected_contact_type', { contacts_id: contacts_id }, function (data) {  
            			 console.log(data); 
						 
						 var response=jQuery.parseJSON(data);
						if(typeof response =='object'){
							data = JSON.parse(data);
							if(data.status=="yes"){
								$.each(data.columns, function(key,value) {
 $(".shortcodes_ul").append('<li><input type="button" value="{'+value+'}"  class="btn-block btn-default btn-flat shortcode_value"/></li>');

				}); 
								
							} 
						}
						
						
       				 });
					
					
					
					
					
					
					/*$.ajax({
					   url: "/text/check_selected_contact_type",
					   type: "GET",
					   data:   { contacts_id: contacts_id},
					  
				   success: function(data)
					  {
						 alert(data); 
					}          
					});	*/
			}
		})
	  
	   
	   
	   
	   
		  $('.contact_source').change(function(){
			  
			
				   var selected_option=$(this).val();
					$('.contact_method').hide(); 
					$('.'+selected_option).show();  
					$("#messageBody").val(''); 
					
				
			});     
			   
			   
		 $('.upload_csv_title_wrapper').hide(); 
			  
		$("#save_for_future_switch").change(function() {
			if(this.checked) {
			  $('.upload_csv_title_wrapper').show(); 
			}else{
				$('.upload_csv_title_wrapper').hide(); 
			}
		});
	   
	   

	   $(".remove_uploaded_csv").click(function(e){
         e.preventDefault();
		 $(".uploaded_user_csv_contact").hide();
		 
		 
		 $(".csv_upload").removeAttr("disabled");
			  $(".csv_upload").attr('value', 'IMPORT CONTACTS');
		 
		 
		 $('#form').trigger("reset");
		  $(".upload_csv_btn").show();
		 
    	}); 
		
		
	   
	   $("#form").on('submit',(function(e) {
		   	$('.csv_upload').attr("disabled", "disabled");
			$(".csv_upload").attr('value', 'Uploading CSV... Please wait');
				
		  
  e.preventDefault();
  $.ajax({
         url: "/index.php/text/upload_csv",
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
    //$("#preview").fadeOut();
    $("#err").fadeOut();
   },
   success: function(data)
      {
		  
		  console.log(data);
		  
		  if(data=="upload_error_extension"){
			  $('.importing_errors').text("Upload A Valid CSV file")
			  $(".csv_upload").removeAttr("disabled");
			  $(".csv_upload").attr('value', 'IMPORT CONTACTS');
		
			  
		 }else if(data=="upload_error_csv_title"){
			  $('.importing_errors').text("Enter the Title  for the contacts")
			  $(".csv_upload").removeAttr("disabled");
			  $(".csv_upload").attr('value', 'IMPORT CONTACTS');
		 
		 }else if(data=="no_telephone_column"){
			 	<?php $suggested_csv_contact_column_names=implode (",  ", $suggested_csv_contact_column_names)?>
		  	$('.importing_errors').text("The CSV you uploaded has no telephone number Column. Please rename the telephone number field as either : <?php echo $suggested_csv_contact_column_names?>.")
			
			  $(".csv_upload").removeAttr("disabled");
			  $(".csv_upload").attr('value', 'IMPORT CONTACTS');
		 
		 }else{
			 
			
			  $('.importing_errors').hide();
			
		
			var response=jQuery.parseJSON(data);
			if(typeof response =='object')
			{
			 	
				$('#modal-upload-csv').modal('hide');
				$(".csv_upload").attr('value', 'IMPORT CONTACTS');
				$('.csv_upload').prop("disabled", false);
				$("#form").trigger('reset');
				$(".upload_csv_btn").hide();
				
				
				data = JSON.parse(data);
				
				
				
				$(".send_contact_id").val(data.insert_id);
				
				$(".uploaded_csv_name").html('<a href="/'+data.path+'" target="_blank"><i class="fa fa-fw fa-file "></i>'+data.csv_title+'</a>');
				$(".uploaded_user_csv_contact").show();
				$(".shortcodes").show();
				
				$(".shortcodes_ul").empty();
				
				/*<input type="button" value="{Account No}" class="btn-block btn-default btn-flat" onclick="insertAtCaret('messageBody','{Account No}');">
				<li><input type="button" value="{'+value+'}"  class="btn-block btn-default btn-flat onclick="insertAtCaret("messageBody","{'+value+'}");" /></li>*/
				
				$.each(data.columns, function(key,value) {
 $(".shortcodes_ul").append('<li><input type="button" value="{'+value+'}"  class="btn-block btn-default btn-flat shortcode_value"/></li>');

				}); 
				
				
				
			}
									
				 
			 
		}
		  
	
      }          
    });
 }));
	   
	   
	   
	   
	   
	   
	   
	   /*$(".import_submit").click(function(){
       		
			
			
			
			
			
			
			
			
    	}); */
	   
	  
	  
	
	  
	  
	   
 });
 
 
 
 
 
 
   /* $(".shortcode_value").click(function(){
       
		alert("me");
		 
    	}); */
		
		var maxchars = 350;

$('#messageBody').keyup(function () {
    var tlength = $(this).val().length;
    $(this).val($(this).val().substring(0, maxchars));
    var tlength = $(this).val().length;
    remain = maxchars - parseInt(tlength);
	
	if(remain <=10){
		$(".counting").addClass("red");	
	}else{
		$(".counting").removeClass("red");	
	}
    $('.remain').text(remain);
});
 
 
 $(document).on('click','.shortcode_value', function()
{
   shortcode=$(this).val();
   
   insertAtCaret('messageBody',shortcode)
 });
   
 
$(".select2").select2({
    //maximumSelectionLength: 1
});
   
   function insertAtCaret(areaId,text) {
	var txtarea = document.getElementById(areaId);
	var scrollPos = txtarea.scrollTop;
	var strPos = 0;
	var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
		"ff" : (document.selection ? "ie" : false ) );
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		strPos = range.text.length;
	}
	else if (br == "ff") strPos = txtarea.selectionStart;
	
	var front = (txtarea.value).substring(0,strPos);  
	var back = (txtarea.value).substring(strPos,txtarea.value.length); 
	txtarea.value=front+text+back;
	strPos = strPos + text.length;
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		range.moveStart ('character', strPos);
		range.moveEnd ('character', 0);
		range.select();
	}
	else if (br == "ff") {
		txtarea.selectionStart = strPos;
		txtarea.selectionEnd = strPos;
		txtarea.focus();
	}
	txtarea.scrollTop = scrollPos;
}




   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>