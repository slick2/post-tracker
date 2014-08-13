<?php $this->load->view('backend/common/header'); ?>
<br />
<p>
	<a href="<?php echo site_url('admin/reports/twitter'); ?>">Twitter</a>&nbsp;&raquo;&nbsp;Info
</p>

<h3>Twitter Info</h3>

<div class="well">
	<p><strong>Poster Name</strong>: <?php echo $tweet['poster_name']; ?>
		<br />
	<p><strong>Followed</strong>: <?php echo $tweet['followed']; ?>
		<br />
	<p><strong>Following</strong>: <?php echo $tweet['following']; ?>
		<br />
	<p><strong>Post Time</strong>: <?php echo $tweet['post_time']; ?>
		<br />
	<p><strong>Retweets</strong>: <?php echo $tweet['retweets']; ?>
		<br />
	<p><strong>Post Tweet</strong>: <?php echo $tweet['post_tweet']; ?>
		<br />
	<p><strong>Post URL</strong>: <a href="<?php echo $tweet['post_url']; ?>" target="_blank"><?php echo $tweet['post_url']; ?></a>



</div>

<?php $this->load->view('backend/common/footer'); ?>

