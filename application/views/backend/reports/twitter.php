<?php $this->load->view('backend/common/header'); ?>
<h3>Twitter Records</h3>

<?php
if (count($twitter_rows))
{
	?>
	<div>
		<?php echo $this->pagination->create_links(); ?>
	</div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Date</th>
				<th>Name</th>
				<th>Post</th>
				<th>Info</th>
			</tr>
		</thead>

		<?php
		foreach ($twitter_rows as $row)
		{
			?>
			<tr>
				<td>
					<?php echo $row['tweet_id']; ?>
				</td>
				<td>
					<?php echo $row['post_time']; ?>
				</td>
				<td>
					<?php echo $row['poster_name']; ?>
				</td>
				<td>
					<?php echo $row['post_tweet']; ?>
				</td>
				
				<td>
					<a href="<?php echo site_url('admin/reports/twitter_read/'.$row['id']);?>">info</a>
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

