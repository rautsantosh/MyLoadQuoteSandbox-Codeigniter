<div class="col-sm-12">
    <?php if(count($Lead) ==0): ?>
    <div class="alert alert-danger">
	<div class="text-center">No Information Available.</div>
    </div>
    <?php else: ?>    
    <div class="text-center">
	<span class="h4">LEAD DETAILS</span>
    </div>
    <table class="table table-bordered table-condensed table-hover table-striped" style="font-size: 12px;">
	<?php foreach ($Lead[0] as $Key => $val): ?>
	<tr><td><?php echo $Key; ?></td><td><?php echo $val; ?></td></tr>
	<?php endforeach; ?>
    </table>
    <?php endif; ?>    
</div>
<div class="clearfix"></div>