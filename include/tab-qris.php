<?php
/**
 * PAYPAL
 */
if (qrcdr()->getConfig('qris') == true) { ?>
   <div class="tab-pane fade <?php if ($getsection === "#qris")
      echo "show active"; ?>" id="qris">
      <h4><?php echo qrcdr()->getString('qris'); ?></h4>
      <div class="row form-group">

         <div class="col-sm-6">
            <label><?php echo qrcdr()->getString('qris_data'); ?></label>
            <input type="text" name="qris_data" class="form-control" required="required">
         </div>

         <div class="col-sm-6">
            <label><?php echo qrcdr()->getString('amount'); ?></label>
            <div class="input-group">
               <input type="number" name="qris_amount" class="form-control" placeholder="0.00">
               <span class="input-group-text rounded-0 getcurrency">IDR</span>
            </div>
         </div>
      </div>

      <div class="row form-group">
         <div class="col-sm-6">
            <label><?php echo qrcdr()->getString('tax_type'); ?></label>
            <select name="tax_type" class="form-control" required="required">
               <option value=""><?php echo qrcdr()->getString('none'); ?></option>
               <option value="percent"><?php echo qrcdr()->getString('percent'); ?></option>
               <option value="amount"><?php echo qrcdr()->getString('amount'); ?></option>
            </select>
         </div>

         <div class="col-sm-6">
            <label><?php echo qrcdr()->getString('tax_rate'); ?></label>
            <div class="input-group">
               <input type="number" name="tax_amount" class="form-control" placeholder="0.00">
               <span class="input-group-text rounded-0 getcurrency">+</span>
            </div>
         </div>
      </div>
   </div>
   <?php
}
