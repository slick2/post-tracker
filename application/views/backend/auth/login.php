<?php $this->load->view('backend/common/header'); ?>

<div class="row">
    <div class="col-md-4">
        <h4>Login</h4>
		<?php $this->load->view('backend/auth/status'); ?>
		<div class="well">
			<form method="post" action="<?php echo base_url() ?>admin/auth/login">
				<div class="form-group">
					<label>Login</label>
					<input type="text" name="login" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control"/>
				</div>

				<div class="form-group">
					<a href="<?php echo base_url() ?>auth/reset_password">Forgot Password</a>
					<br />
					<input type="submit" value="login" class="btn btn-primary"/>
				</div>

			</form>
		</div>
    </div>
</div>
<?php $this->load->view('backend/common/footer'); ?>

