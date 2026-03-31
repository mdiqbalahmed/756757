<?php $this->Form->unlockField('name'); ?>
<?php $this->Form->unlockField('email'); ?>
<?php $this->Form->unlockField('phone'); ?>
<?php $this->Form->unlockField('body'); ?>
<?php echo $this->Form->create('Comment', ['id' => 'form1', 'class' => 'visible-class'] ); ?>
<div class="">
      <div class="row">

            <div class="col-12 mt-2">
                  <input name="name" type="text" class="form-control" placeholder="নাম :" required>
            </div>
            <div class="col-6 mt-2">
                  <input name="email" type="email" class="form-control" placeholder="ইমেল :" required>
            </div>
            <div class="col-6 mt-2">
                  <input name="phone" type="tel" class="form-control" placeholder="ফোন :" required>
            </div>
            <div class="col-12 mt-2">
                  <textarea name="body" class="form-control" rows="2" placeholder="মন্তব্য :"></textarea>
            </div>
            <div class="col-12 mt-2 text-right">
                  <button type="submit" class="subbtn2 btn btn-light text-right"><?= __d('boxes', 'পাঠান') ?></button>
            </div>

      </div>
      <?php echo $this->Form->end(); ?>
</div>