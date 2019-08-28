	<strong>EXPORT REPORT: </strong>
            <p>Leave the below options blank and click on Export Report if you need a full import of all SMS, Check any of the options to filter SMS.</p>
            
            <?php echo Form::open(['action'=>'ReportsController@filtered_generate_excel','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']); ?>

            
              <div class="form-group">
                  <div class="checkbox">
                  
                
                    <label>
                    <?php echo e(Form::checkbox('status[]','2',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Delivered SMS </strong>
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                     <label>
                    <?php echo e(Form::checkbox('status[]','3',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     <strong>	Undelivered SMS</strong>
                    </label>
                     &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                     <label>
                    <?php echo e(Form::checkbox('status[]','1',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Queed SMS</strong>
                    </label>
                    
                      &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                     <label>
                    <?php echo e(Form::checkbox('status[]','4',null, array('id'=>'published'))); ?>

                     <!-- <input type="checkbox" name="status[]" value="published">-->
                     	<strong>Cancelled SMS</strong>
                    </label>
                    
                    
                     &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <button type="submit" name="export" class="btn btn-default" >EXPORT REPORT</button>
                  </div>
                  </div>
                  
                  <input type="hidden" name="text_id" value="<?php echo e($text_details->text_id); ?>">
            
             <?php echo Form::close(); ?>