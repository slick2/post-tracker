<?php $this->load->view('backend/common/header'); ?>
<div class="clear">&nbsp;</div>
<div class="row">
	<div class="col-md-3">
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin/campaigns'); ?>">Campaigns</a>
			</li>
			<li class="active">
				Add
			</li>
		</ol>
	</div>
</div>
<h3>Add Campaign</h3>
<div class="row">
    <div class="col-md-6">
		<div class="well">
			<form method="post">
				<div class="form-group">
					<label>Name:</label>
					<input type="text" name="name" class="form-control" placeholder="Campaign Name" value="<?php echo set_value('name')?>"/>       
				</div>

				<div class="form-group">
					<label>Hashtags(1 per row)</label>
					<textarea name="hashtags" class="form-control" placeholder="Hashtags"><?php echo set_value('hashtags');?></textarea>				
				</div>
				<div class="form-group">
					<label>Facebook Pages to Track(1 per row)</label>
					<textarea name="facebook_pages" class="form-control" placeholder="Facebook Pages"><?php echo set_value('facebook_pages')?></textarea>
				</div>

				<div class="form-group">
					<label>Twitter Pages to Track(1 per row)</label>
					<textarea name="twitter_pages" class="form-control" placeholder="Twitter Pages"><?php echo set_value('twitter_pages')?></textarea>
				</div>
				
				<div class="form-group">
					<label>Youtube Channels to Track(1 per row)</label>
					<textarea name="youtube_channels" class="form-control" placeholder="Youtube Channels"><?php echo set_value('youtube_channels')?></textarea>
				</div>
				
				<div class="form-group">
					<label>RSS Feeds to Track (1 per row) </label>
					<textarea name="rss_feeds" class="form-control" placeholder="RSS Feeds"><?php echo set_value('rss_feeds');?></textarea>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-default">Submit</button>
					<button type="button" class="btn btn-default" onclick="location.href = '/admin/campaigns'">Cancel</button>
				</div>
			</form>
		</div>
    </div>
</div>

<?php $this->load->view('backend/common/footer'); ?>