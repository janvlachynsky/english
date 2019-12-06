<div class="uk-section uk-section-secondary vocabs_all" style="margin-top:10px;">
	<div class="uk-width-xlarge" style="margin:0 auto;">
			
	<table class="uk-table uk-table-divider uk-table-small">
		<thead>
			<th>
			<td>#</td>
			<td>Czech</td>
			<td>English</td>
			<td>Source</td>
			<td>id</td>
		</th>
		</thead>
		<?php foreach ($vocabs as $key => $value):?>
		<tr>
			<td>	</td>
			<td><?=$key;?></td>
			<td><?=$value['czech'];?></td>
			<td><?=$value['english'];?></td>
			<td><?=$value['source'];?></td>
			<td><?=$value['id'];?></td>
			
		</tr>
	<?php endforeach;?>
	</table>

	<div class="paginationdiv">
		<div>
				<?= $this->pagination->create_links();?>
		</div>	
			</div>
</div>
</div>