

<?php $__env->startSection('title', 'Vehicles'); ?>

<?php $__env->startSection('content_header'); ?>
   <h1><i class="fa fa-fw fa-phone "></i> New Contact List</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   
    <div class="box">
            
            
              <div class="box-header with-border">
                <h5 class="box-title">Create a New Contact List</h5>

              </div>
              
              <div class="alert alert-success alert-dismissible sucess_pop" style="display:none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Contact Successfully Saved!</h4>
               <a href="/contact/create" class="btn btn-flat btn-info">Add New Record</a>
              </div>
              
              
              
              
              <div class="new_record_wrapper">
              
                 <form id="form" action="" method="post" enctype="multipart/form-data">
             
              <div class="box-body">
              
                 <div class="row">
                  	<div class="col-md-12">
                    	<?php echo e(Form::label('contacts_title', 'Contact List Title* ')); ?>

                         <div class="form-group">
                               <?php echo e(Form::text('contacts_title', $contact->contacts_title,['class'=>'form-control', 'placeholder'=>'Enter your Contacts List Title','required'=>'required'])); ?>

                        </div>
            	   </div>
                   </div>
              
             <div class="row">
                       
                     
                         <div class="col-md-12">
                      <h4>Select Contacts Source</h4>
                      
                      </div>
                      
                      
                      
                      
                       <div class="col-md-3">
                
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="csv" required 
                  <?php if($contact->contacts_from=='csv'): ?> checked <?php endif; ?>
                  
                  >
                <i class="fa fa-fw fa-file "></i> Import from a CSV File
                </label>
                
                
                
                
               </div>
                      
                       
                        <div class="col-md-3">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="phone_book" required
                  
                  <?php if($contact->contacts_from=='phone_book'): ?> checked <?php endif; ?>
                  > 
                  <i class="fa fa-fw fa-list "></i>Enter Contacts
                </label>
                
                </div>
                
               
               
               
            
                
                       </div>
              
              
               <div class="row">
                  	  	<div class="col-md-12 contact_method phone_book" <?php if($contact->contacts_from!='phone_book'): ?>  style="display:none" <?php endif; ?>>
                    <br>
                    	 <table id="myTable" class=" table order-list table-bordered table-striped">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Telephone </th>
            <th>Email</th>
             <th></th>
        </tr>
    </thead>
    <tbody>
    
    
    
       <?php $contacts_array = (array) json_decode($contact->phone_book_contacts);
	   $key_count=1;
	   
	   ?>
                <?php if($contact->contacts_from=='phone_book'): ?>
                  <?php if(count($contacts_array)>0): ?>
                   
                   		<?php $__currentLoopData = $contacts_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contacts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
            <td>
                <input type="text" name="contact_list[<?php echo $key_count?>][first_name]" class="form-control" placeholder="Enter First Name" 
                value="<?php echo e($contacts->first_name); ?>"   />
            </td>
            
             <td>
                <input type="text" name="contact_list[<?php echo $key_count?>][last_name]"   class="form-control"  placeholder="Enter Last Name" 
                 value="<?php echo e($contacts->last_name); ?>" >
            </td>
            <td>
                <input type="text" name="contact_list[<?php echo $key_count?>][phone]"  class="form-control" placeholder="Enter The phone"  
                 value="<?php echo e($contacts->phone); ?>"
               
                />
            </td>
            
             <td>
                <input type="text" name="contact_list[<?php echo $key_count?>][email]"  class="form-control" placeholder="Enter Email" 
                 value="<?php echo e($contacts->email); ?>"
                 />
            </td>
           <td>
           <button  class="ibtnDel btn btn-xs btn-danger btn-flat " >  <strong>  <i class="fa fa-close"></i></strong></button>
           
           </td>
           
        </tr>
                        <?php   $key_count++; ?>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                   <?php endif; ?>
                    <?php endif; ?>
      
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: left;">
                <input type="button" class="btn btn-flat btn-sm" id="addrow" value="Add New Item" />
            </td>
        </tr>
       
    </tfoot>
</table>
                        
               
            	   </div>
                   
                   
                   
                   
                   
                   
                    	<div class="col-md-12 contact_method csv"  <?php if($contact->contacts_from!='csv'): ?>  style="display:none" <?php endif; ?>>
         
         
         <br>
         
         						   <div class="col-md-6">
                                   
                               
                                   
                                     <br>
                <?php if($contact->contacts_from=='csv'): ?> 
                	<a href="/<?php echo e($contact->csv_file); ?>" class="btn btn-sm btn-default btn-flat"><strong><i class="fa fa-fw fa-download "></i> VIEW UPLOADED CSV</strong></a>
                
                <?php endif; ?>
                 <br>
                 <br>
                  
               			  <?php echo e(Form::label('csv_file', 'Upload CSV file')); ?>

                
                         <div class="form-group">
                             <?php echo e(Form::file('csv_file',['class'=>'form-control'])); ?>

                        </div>
                 
                    
                    </div>
                       
            	   </div>
                   
                   
 
                   
                 
                   </div>
          
              </div>
              
              
               <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-flat">SUBMIT DETAILS</button>
              </div>
              
              
              
              </div>
              <input type="hidden" name="contact_id" value="<?php echo e($contact->contacts_id); ?>">
             <?php echo Form::token(); ?>

              
              </form>
                
   </div>
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
	
	
	
	$(document).ready(function() {
		
		
		var continue_process=true;
		
		 
	   $("#form").on('submit',(function(e) {
		   
		   var contacts_title=$(".contacts_title").val();
		      var contacts_title=$(".contacts_title").val();
			  var contact_source=$(".contact_source").val();
		   
		   
		  
			 
			 
			 
		   
		  
  e.preventDefault();
  $.ajax({
         url: "http://62.8.88.218:98/index.php/contact/create_ajax",
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
				alert("Upload a valid CSV File");	
			}
			
			
			if(data=="success"){
				$(".new_record_wrapper").hide();
				$(".sucess_pop").show();
					
			}
			
		  
	
      }          
    });
 }));
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		 var counter = <?php echo $key_count+1 ?>;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

       cols += '<td><input type="text" class="form-control" name="contact_list['+counter+'][first_name]"  placeholder="Enter First Name" /></td>';
	  cols += '<td><input type="text" class="form-control" name="contact_list['+counter+'][last_name]"  placeholder="Enter Last Name"  /></td>';
     cols += '<td><input type="text" class="form-control" name="contact_list['+counter+'][phone]"  placeholder="Enter Telephones"  /></td>';
	  cols += '<td><input type="text" class="form-control" name="contact_list['+counter+'][email]"  placeholder="Enter Email"  /></td>';
        cols += '<td><button  class="ibtnDel btn btn-xs btn-danger btn-flat " >  <strong>  <i class="fa fa-close"></i></strong></button></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });

		
		
		
		
		
		
	 
	 
	  $('.contact_source').change(function(){
			  
			
				   var selected_option=$(this).val();
					$('.contact_method').hide(); 
					$('.'+selected_option).show();  
					$("#messageBody").val(''); 
					
				
			});     
			
			}); 
			
			
			
			
			
			
			
			
			
			
			
			
			
			  
			   
	
	 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>