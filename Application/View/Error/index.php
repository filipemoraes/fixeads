<?php $this->block('body'); ?>
    <div class="wrapper wrapper--center">
        <h1>Ops! An error has occurred!</h1>
        <p>
            <?php echo $this->code; ?>
            <?php if($this->message) : ?>
                <br/><br/><b>Message:</b><br/><?php echo $this->message; ?>
            <?php endif; ?>
        </p>
    </div>
<?php $this->endBlock(); ?>
<?php $this->extend('base'); ?>
