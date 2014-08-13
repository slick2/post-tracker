<?php $this->load->view('backend/common/header'); ?>
<div class="row>
<?php #print_r($campaigns); ?>
     <div class="col-mid-12">
     <h2>Campaigns</h2>
    <a href="<?php echo base_url() ?>backend/campaigns/add" class="btn btn-primary">Add</a>
    <?php if (count($campaigns)) { ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php foreach ($campaigns as $campaign) { ?>
                <tr>
                    <td>
                        <?php echo $campaign['id'] ?>
                    </td>
                    <td><?php echo $campaign['name'] ?>
                    </td>
                    <td>
                        
                        <a href="<?php echo base_url() . 'admin/campaigns/view/' . $campaign['id'] ?>" class="btn btn-default btn-xs">view</a>&nbsp;
                        <a href="<?php echo base_url() . 'admin/campaigns/edit/' . $campaign['id'] ?>" class="btn btn-info btn-xs">edit</a>&nbsp;
                        <a href="<?php echo base_url() . 'admin/campaigns/remove/' . $campaign['id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Remove record ?')" >remove</a>&nbsp;
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="alert">
            Sorry No Available Records!
        </div>
    <?php } ?>
</div>



<?php $this->load->view('backend/common/footer'); ?>
