@extends('adminlte::page')

@section('title', 'Contact Lists')

@section('content_header')
   <h1><i class="fa fa-fw fa-phone "></i> New Contact List</h1>
@stop

@section('content')
   
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
                    	{{Form::label('contacts_title', 'Contact List Title* ')}}
                         <div class="form-group">
                             {{Form::text('contacts_title', '',['class'=>'form-control', 'placeholder'=>'Enter your Contacts List Title','required'=>'required'])}}
                        </div>
            	   </div>
                   </div>
              
             <div class="row">
                       
                     
                         <div class="col-md-12">
                      <h4>Select Contacts Source</h4>
                      
                      </div>
                      
                      
                      
                      
                       <div class="col-md-3">
                
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="csv" required>
                <i class="fa fa-fw fa-file "></i> Import from a CSV File
                </label>
                
               </div>
                      
                       
                        <div class="col-md-3">
                        <label>
                  <input type="radio" name="contact_source" class="flat-red contact_source" value="phone_book" required> 
                  <i class="fa fa-fw fa-list "></i>Enter Contacts
                </label>
                
                </div>
                
               
               
               
            
                
                       </div>
              
              
               <div class="row">
                  	<div class="col-md-12 contact_method phone_book" style="display:none">
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
        <tr>
            <td>
                <input type="text" name="contact_list[0][first_name]" class="form-control" placeholder="Enter First Name"   />
            </td>
            
             <td>
                <input type="text" name="contact_list[0][last_name]"   class="form-control"  placeholder="Enter Last Name" >
            </td>
            <td>
                <input type="text" name="contact_list[0][phone]"  class="form-control" placeholder="Enter The phone"  />
            </td>
            
             <td>
                <input type="text" name="contact_list[0][email]"  class="form-control" placeholder="Enter Email"  />
            </td>
           <td></td>
           
        </tr>
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
                   
                   
                   
                   
                   
                   
                    	<div class="col-md-12 contact_method csv"  style="display:none">
         
         
         <br>
         
         						   <div class="col-md-6">
                  
               			  {{Form::label('csv_file', 'Upload CSV file')}}
                
                         <div class="form-group">
                             {{Form::file('csv_file',['class'=>'form-control'])}}
                        </div>
                 
                    
                    </div>
                       
            	   </div>
                   
                   
              
                   
                   
                   
                   
                   
                   
                 
                   </div>
              
              
              
              
              
              
              
              
              
              </div>
              
              
               <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-flat">SUBMIT DETAILS</button>
              </div>
              
              
              
              </div>
              
             {!! Form::token() !!}
              
              </form>
                
   </div>
   
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
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
			
			
			if(data=="no_telephone_column"){
				<?php $suggested_csv_contact_column_names=implode (",  ", $suggested_csv_contact_column_names)?>
				alert("The CSV you uploaded has no telephone number Column. Please rename the telephone number field as either : <?php echo $suggested_csv_contact_column_names?>.");	
			}
			
			
			
			if(data=="success"){
				$(".new_record_wrapper").hide();
				$(".sucess_pop").show();
					
			}
			
		  
	
      }          
    });
 }));
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		 var counter = 1;

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
@stop