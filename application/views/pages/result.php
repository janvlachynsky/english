<table class="uk-table uk-table-divider uk-table-striped  uk-table-small">
	<thead>
		<th>
			<td>#</td>
			<td>Czech</td>
			<td>English</td>
			<td>Answered</td>
			<td>Id</td>
			<td>Result</td>
			<td>Attempts</td>
			<td>Score</td>
		</th>
		</thead>
		<tbody>
			<?php

				foreach($vocabs as $key => $val):
					?>
		<tr>
			<td></td>
			<td><?=$key++?></td>
			<td><?=$val['czech']?></td>
			<td><?=$val['english']?></td>
			<td><?=$val['answer']?></td>

			<td><?=$val['id']?></td>
			<td><?=$val['result']?></td>
			<td><?=$val['count']?></td>
			<td><?=$val['score']?></td>
			
		</tr>
	<?php endforeach;?>
	</tbody>
</table>