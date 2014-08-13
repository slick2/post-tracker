<?php $this->load->view('backend/common/header'); ?>
<h3>Facebook Records</h3>

<?php
if (count($facebook_rows))
{
	?>
	<div>
		<?php echo $this->pagination->create_links(); ?>
	</div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Post</th>
			</tr>
		</thead>

		<?php
		foreach ($facebook_rows as $row)
		{
			?>
			<tr>
				<td>
					<?php echo $row['post_id']; ?>
				</td>
				<td>
					<?php echo $row['poster_name']; ?>
				</td>
				<td>
					<?php echo $row['post_content']; ?>
				</td>
				
				
			</tr>

			<?php
		}
		?>

	</table>
	<?php
}
else
{
	?>	
	<p>No Available Records</p>
	<?php
}
?>

<?php $this->load->view('backend/common/footer'); ?>