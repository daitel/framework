<?php
/**
 * Daitel Framework
 * Phone Book main template file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */
?>
<table class="table">
	<thead>
	<tr>
		<th>
			Name
		</th>
		<th>
			Phone
		</th>
	</tr>
	</thead>

	<tbody>
	<?php foreach ($data as $phone) { ?>
		<tr>
			<td>
				<?php echo $phone['name']; ?>
			</td>
			<td>
				<?php echo $phone['phone']; ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>


</table>
