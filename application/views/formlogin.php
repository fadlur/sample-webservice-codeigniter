<div class="container">
	<br>
	<div class="row">
		<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
			<div class="panel panel-success">
				<div class="panel-heading"><span class="glyphicon glyphicon-log-in"></span> Login</div>
				<div class="panel-body">
					<?php //echo $this->session->flashdata('message');
					echo $message; ?>
					<form action="<?php //echo site_url('login'); ?>" method="POST">
						<div class="form-group">
							<?php echo form_error('username'); ?>
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" autofocus="true">
						</div>
						<div class="form-group">
							<?php echo form_error('password'); ?>
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<div class="form-group">
							<label>
								<?php echo form_checkbox('remember','1',TRUE);?> Remember me
							</label>
						</div>
						<div class="form-group">
							<button class="btn-primary btn form-control" id="loginbutton">Login</button>
							<p class="help-block">Belum punya akun? Daftar <a href="<?php echo site_url('register') ?>">Disini</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
