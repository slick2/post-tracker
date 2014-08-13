<?php $this->load->view('backend/common/header'); ?>
<div class="clear">&nbsp;</div>
<div class="row">
	<div class="col-md-3">
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin/campaigns'); ?>">Campaigns</a>
			</li>
			<li class="active">
				View
			</li>
		</ol>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>Campaign: <?php echo $campaign['name']; ?></h3>
		<p>Hashtags</p>
		<pre><?php echo trim($campaign['hashtags']); ?></pre>
		<p>Facebook Pages</p>
		<pre><?php echo $campaign['facebook_pages']; ?></pre>
		<p>Twitter Pages</p>
		<pre><?php echo $campaign['twitter_pages']; ?></pre>
		<p>Youtube Pages</p>
		<pre><?php echo $campaign['youtube_channels']; ?></pre>
		<p>RSS Feeds</p>
		<pre><?php echo $campaign['rss_feeds']; ?></pre>
		<div class="form-group">
			<button class="btn btn-default" onclick="location.href='<?php echo site_url('admin/campaigns')?>'">Go back to Campaigns</button>
		</div>
</div>

<?php $this->load->view('backend/common/footer'); ?>