
<?php $this->load->view('header'); ?>
<div class="row">
    <div class="col-md-6">
        <h3>Social Profile</h3>

        <form method="post">
            <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" />
            <div class="form-group">
                <label>Site:</label>
                <select name="site_id" class="form-control">
                <?php foreach ($sites as $site) { ?>
                            <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>

                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>User Handle:</label>
                <input type="text" name="name" class="form-control"/>
            </div>
            <button type="submit" class="btn btn-default">Add Social Profile</button>
        </form>
    </div>
</div>
<?php #print_r($sites);?>
<?php $this->load->view('footer'); ?>