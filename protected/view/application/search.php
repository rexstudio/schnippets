<?php if (empty($result)) : ?>

<h3>No Results</h3>

<?php else : ?>

<h3><?php print $title; ?></h3>

<table>
	<thead>
		<tr>
			<th>Schnippet</th>
			<th>Language</th>
			<th>User</th>
			<th>Posted</th>
		</tr>
	</thead>
	<tbody>
                <?php 
                        
                ?>        
		<?php foreach ($result as $record) : ?>
		<tr>
			<td><a href="?route=/application/schnippets&m=get&id=<?php echo $record->getMember('id'); ?>"><?php echo emptyString($record->getMember('title')); ?></a></td>
			<td><?php echo $record->getMember('lang'); ?></td>
			<td><?php 
                            $usr = $user->get_user($record->getMember('user')); 
                            echo "{$usr['fname']} {$usr['lname']}";
                        ?></td>
			<td><?php echo date('m/d/Y', $record->getMember('time')); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>