<?php

/**
 * post_tweet = test
 */
?>



<?php
/*  Twitter Hash

  foreach($twitter_hash->statuses as $tw_data)
  {
  ?>
  <p>Poster Name: <?php echo $tw_data->user->name; ?></p>
  <p>Followed: <?php echo $tw_data->user->followers_count; ?></p>
  <p>Following: <?php echo $tw_data->user->friends_count;?></p>
  <p>Time of Posts : <?php echo $tw_data->created_at; ?></p>
  <p>Retweets: <?php echo $tw_data->retweeted; ?></p>
  <p>Post Tweet : <?php echo $tw_data->text; ?></p>
  <p>Post URL: <?php echo 'http://twitter.com/'.$tw_data->user->name.'/status/'.$tw_data->id; ?>

  <?php

  }
 */
?>
<?php 
/* Twitter Profile */
/*
foreach($twitter_profile as $tw_data)
  {
  ?>
  <p>Poster Name: <?php echo $tw_data->user->name; ?></p>
  <p>Followed: <?php echo $tw_data->user->followers_count; ?></p>
  <p>Following: <?php echo $tw_data->user->friends_count;?></p>
  <p>Time of Posts : <?php echo $tw_data->created_at; ?></p>
  <p>Retweets: <?php echo $tw_data->retweeted; ?></p>
  <p>Post Tweet : <?php echo $tw_data->text; ?></p>
  <p>Post URL: <?php echo 'http://twitter.com/'.$tw_data->user->name.'/status/'.$tw_data->id; ?>

  <?php

  }
 * 
 */
?>

<?php

/** Instagram Hash 
 * Poster Name
 * Followed
 * Following
 * Time of Post
 * Post Image URL
 * No of likes
 * hashtags content
 * post url
 */
?>

<?php
/*
foreach($instagram_hash->data as $ig_data)
{
	?>
<p>Poster Name: <?php echo $ig_data->user->username;?></p>
<p>Followed: <?php ?></p>
<p>Following: <?php ?></p>
<p>Time of Post: <?php echo $ig_data->created_time; ?></p>
<p>Post Image URL: <?php echo $ig_data->images->standard_resolution->url?></p>
<p>Number of likes: <?php echo $ig_data->likes->count; ?></p>
<p>Hash Tag Content: <?php echo $ig_data->caption->text; ?></p>
<p>Post URL: <?php echo $ig_data->link; ?></p>
<?php	
echo '<pre>';
print_r($ig_data); 
echo '</pre>';
break;
 * 
 
}
 * 
 * 
 */
?>

<?php /** Facebook Profile **/?>

<?php foreach($facebook_profile['data'] as $fb){?>
<p>Poster Name: <?php echo $fb->from->name?></p>
<p>Time of Post: <?php echo $fb->created_time;?></p>
<p>Followers Friends:</p>
<p>Post Content:<?php echo $fb->message?></p>
<p>Number of Likes: echo !empty($fb->likes) ? count($fb->likes->data) : 0 ;?>? </p>
<p>Post Image URL:<?php echo !empty($fb->picture) ? $fb->picture : ''?></p>
<p>Post URL:<?php echo $fb->actions[0]->link?></p>
<?php 
echo '<pre>';
#print_r($fb);
echo '</pre>';
break;

} ?>
<pre>

<?php #print_r($facebook_profile); ?>
</pre>
