<div class="col-sm-12">
    <?php foreach ($data as $row): ?>
	<?php foreach ($row as $key => $val): ?>
	    <div class="col-sm-2">
		<div class="panel panel-primary">
		    <div class="panel-heading"><div class="h4"><?php echo $val; ?></div></div>
		    <div class="panel-footer"><?php echo $key; ?></div>
		</div>
	    </div>
	<?php endforeach; ?>
    <?php endforeach; ?>
</div>