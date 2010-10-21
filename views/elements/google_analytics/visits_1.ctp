<tr>
	<td><?php
		$unit = 'am';
		if($when >= 12) {
			$unit = 'pm';
		}
		
		if($when > 12) {
			$when -= 12;
		} else if($when == 0) {
			$when = 12;
		}
		
		echo ltrim($when, '0') . ':00' . $unit;
	?></td>
	<td><?php echo $count ?></td>
</tr>