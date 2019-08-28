     <div class="modal fade" id="contacts-modal<?php echo e($text->text_id); ?>">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo e($text->text_title); ?> Recepient List</h4>
              </div>
              <div class="modal-body">
               
               	<?php  
				
	
		
					$recepient_contacts = explode(',', $text->recepient_contacts);
					$trimmed_contacts = array_map('trim',$recepient_contacts);
				?> 
                
                
                
                <?php $__currentLoopData = $trimmed_contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                	<li style="width:150px; float:left;"><?php echo e($contact); ?></li>
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <div style="clear:both"></div>
                
                
                
               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right btn-sm btn-flat " data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                          