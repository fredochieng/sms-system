

<?php $__env->startSection('title', 'Create SMS'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fa fa-fw fa-envelope "></i> Edit SMS/Campaign</h1>
<?php $__env->stopSection(); ?>

<style>


.counting{font-size:18px; padding-top:10px}
.remain{font-weight:bold}
.red{ color:#ef1616}

</style>

<?php $__env->startSection('content'); ?>
    <div class="box with-border">
   
               <?php echo Form::open(['action'=>'TextController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

              <div class="box-body">
              		
                        <div class="row">
                  	<div class="col-md-12">
                    	<?php echo e(Form::label('title', 'Title of your SMS / Campaign* ')); ?>

                         <div class="form-group">
                             <?php echo e(Form::text('title', $text->text_title,['class'=>'form-control', 'placeholder'=>'Enter your Sms/Campaign Title', 'required'=>'required'])); ?>

                             
                             
                        </div>
            	   </div>
                   </div>
                   
                   
                   
                       <div class="row">
                       
                     
                         <div class="col-md-12">
                      <h4>Select Contacts Source</h4>
                      
                      </div>
                       
                        <div class="col-md-3">
                        
                        <div style="display:none">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="contact_list"
                  <?php if($text->from_source=='contact_list'): ?> checked <?php endif; ?> > 
                  <i class="fa fa-fw fa-list "></i>From a Saved Contact List
                </label>
                </div>
                </div>
                
                <div class="col-md-3">
                  <div style="display:none">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="csv_upload"
                   <?php if($text->from_source=='csv_upload'): ?> checked <?php endif; ?>
                  
                  >
                <i class="fa fa-fw fa-file "></i> Import from a CSV/Excel File
                </label>
                
                </div>
                
               </div>
               
               
                <div class="col-md-3">
                <div style="display:none">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="recepient_contacts"
                    <?php if($text->from_source=='recepient_contacts'): ?> checked <?php endif; ?>
                  >
                <i class="fa fa-fw fa-phone "></i> Enter Recipient Contacts
                </label>
                </div>
               </div>
                
                       </div>
                       <br>
                   
                   
                   
                      <div class="row">
                      
                  	<div class="col-md-12 contact_method contact_list"  <?php if($text->from_source!='contact_list'): ?> style="display:none" <?php endif; ?>>
                    	<?php echo e(Form::label('recepients_contact_list', 'Recepients From a  Contact List')); ?>

                         <div class="form-group">
                             
                             <input type="hidden" name="contact_list_sel" value="<?php echo e($text->contacts_id); ?>">
                             <select class="form-control select2  " multiple  data-placeholder="Select a Contact"
                        style="width: 100%;" name="contact_list" disabled>
                 
                 <?php if(count($contacts)>0){ 
				 	foreach($contacts as $contact) {
				 
				 ?>
                 
                 
                 
                  <option value="<?php echo $contact->contacts_id?>" <?php if($contact->contacts_id==$text->contacts_id && $text->from_source=='contact_list'){echo "selected";}?>><?php echo $contact->contacts_title?></option>
                  
                  <?php } ?>
                 
                 
                 <?php } ?>
                </select>
                        </div>
                        
               
            	   </div>
                   
                   
                   
                   
                   
                   
                    	<div class="col-md-12 contact_method csv_upload"  <?php if($text->from_source!='csv_upload'): ?> style="display:none" <?php endif; ?>>
                         <?php if($text->from_source=='csv_upload'): ?> 
                         	 <a href="/<?php echo e($text->contact_details->csv_file); ?>" class="btn btn-default btn-xs btn-flat">DOWNLOAD UPLOADED CSV</a> <BR><br>
                          
                          <?php endif; ?>
                          
                          <div style="display:none">
          <button type="button" class="btn btn-info btn-sm btn-flat upload_csv_btn" data-toggle="modal" data-target="#modal-upload-csv"><strong><i class="fa fa-fw fa-upload"></i>UPLOAD CONTACTS FROM A CSV FILE</strong>
              </button>
              </div>
              
              
            <h4 class="uploaded_user_csv_contact" style="display:none">
            
            
            <span class="uploaded_csv_name"></span>
           <a href="" class="remove_uploaded_csv"> <span style="color:#E41114"><i class="fa fa-fw fa-close"></i></span></a>
            
         
            
            </h4>
            
         
                       
            	   </div>

                   
                   <div class="col-md-12 contact_method recepient_contacts"  <?php if($text->from_source!='recepient_contacts'): ?> style="display:none" <?php endif; ?>>
                    	<?php echo e(Form::label('recepients_phone_nos', 'Recepients Phone Numbers with Country Code (Comma separated)')); ?>

                         <div class="form-group">
                             <?php echo e(Form::textarea('recepients_phone_nos',  $text->recepient_contacts,['class'=>'form-control recepient_contacts', 'placeholder'=>'Comma separated Phone numbers e.g: 254713295853, 254123459789, 254987654321 '])); ?>

                        </div>
                        
                      
                        <div style="clear:both"></div>
            	   </div>
                   
                 
                   </div>
                   
                   <div style="clear:both"></div>
                   
                    <div class="row" style="padding-top:20px">
                   
                    
                      
                   
                  	<div class="col-md-12">
                    
                     <?php  if($text->from_source=="csv_upload" || $text->from_source=="contact_list"){ ?>
                     <span style="float:right; margin-right:100px;" class="shortcodes">
                     
 
                     
                     <?php 
					 
					
						if($text->from_source=="csv_upload"){
						 	$tags_array=json_decode($text->contact_details->csv_file_columns);
						 }elseif($text->from_source=="contact_list"){
							 $tags_array=json_decode($text->contact_details->phone_book_columns);
						}
					 
					 
					
					 
					 // ?>
                    <div class="btn-group">
                  <button type="button" class="btn  btn-flat btn-info dropdown-toggle btn-sm" data-toggle="dropdown"><strong>{&nbsp; }</strong></button>
                
                  <ul class="dropdown-menu shortcodes_ul" role="menu" style="padding: 0px 0; height:250px; overflow:auto">
                  
                  		
    					<?php 
						if($tags_array){
						foreach($tags_array as $tag){ ?> 
						
							<li><input type="button" value="{<?php echo $tag?>}" class="btn-block btn-default btn-flat shortcode_value"></li>
						
						<?php } }?>
                  
                  </ul>
                </div>
                    </span>
                    
                    <?php } ?>
                      <br>
                    
                    <div style="clear:both"></div>
                    
                    
                    
                    	<?php echo e(Form::label('messageBody', 'Your message')); ?>

                         <div class="form-group">
                             <?php echo e(Form::textarea('messageBody', $text->message,['class'=>'form-control', 'placeholder'=>'Enter your Sms/Campaign Title'])); ?>

                        
                        <p class="counting"> <span class="remain">-</span> characters remaining</p>
                        
                        </div>
                        
                     
            	   </div>
                   
                 <!--  <div class="col-md-12">
                   <input type="button" value="<<Account No>>" onclick="insertAtCaret('messageBody','<<Account No>>');" />
                   <input type="button" value="<<FirstName>>" onclick="insertAtCaret('messageBody','<<FirstName>>');" />
                  <input type="button" value="<<LastName>>" onclick="insertAtCaret('messageBody','<<LastName>>');" />
               
                   </div>
                   -->
                  
                   </div>
                    
               
               <?php if($text->status=='draft'): ?> 

             <div class="col-md-12" style="padding-left:0px">
             <label for="messageBody">Published/Draft</label>
             <div class="form-group">
    	<select name="status" class="form-control" style="width:200px">
        	<option value="draft">Draft</option>
            <option value="published">Published</option>
        
        </select>
    </div>
    </div>
    
     <?php else: ?>
     	<input type="hidden" name="status" value="<?php echo e($text->status); ?>">
    
   	 <?php endif; ?>
              
    </div>
    
    
    
    
     <div class="box-footer">
                <button type="submit" class="btn btn-success btn-flat"><strong><i class="fa fa-fw fa-share-square"></i> SAVE CHANGES</strong></button> &nbsp;
                 
              </div>
              
              
                 <input type="hidden" class="send_contact_id" name="send_contact_id" value="<?php echo e($text->contacts_id); ?>">
                  
                  <input type="hidden"  name="text_id" value="<?php echo e($text->text_id); ?>">
              
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
   $(document).ready(function() {
	   
	   $('.contact_list_sel').on('change', function() {
		   $(".shortcodes_ul").empty();
		   $(".shortcodes").show();
 			var contacts_id=this.value;
			if(contacts_id){
					
					$.get('/text/check_selected_contact_type', { contacts_id: contacts_id }, function (data) {  
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
         url: "/text/upload_csv",
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
		
		
		var maxchars = 160;

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
    maximumSelectionLength: 1
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