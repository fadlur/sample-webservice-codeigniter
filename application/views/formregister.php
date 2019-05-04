<div class="container">
	<br>
	<div class="row">
		<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
			<div class="panel panel-success">
				<div class="panel-heading"><span class="glyphicon glyphicon-log-in"></span> Registration</div>
				<div class="panel-body">
					<?php //echo $this->session->flashdata('message');
					echo $message; ?>
					<form action="<?php //echo site_url('register'); ?>" method="POST">
                        <div class="form-group">
							<label for="first_name">Nama Depan</label>
							<input type="text" class="form-control" id="first_name" name="first_name" autofocus="true">
						</div>
                        <div class="form-group">
							<label for="last_name">Nama Belakang</label>
							<input type="text" class="form-control" id="last_name" name="last_name">
						</div>
                        <div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" id="email" name="email">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
                        <div class="form-group" id="errordiv">
                        </div>
						<div class="form-group">
							<button class="btn-primary btn form-control" id="registerbutton">Daftar</button>
							<p class="help-block">Sudah punya akun? silahkan login <a href="<?php echo site_url('login')?>">disini</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).on('click','#registerbutton',daftar);
    function daftar(e){
        e.preventDefault();
        var datapendaftaran = {'first_name':$('#first_name').val(),
        'last_name':$('#last_name').val(),
        'email':$('#email').val(),
        'username':$('#username').val(),
        'password':$('#password').val()};console.log(datapendaftaran);
        $.ajax({
            url : '<?php echo site_url("register/prosesdaftar")?>',
            data : datapendaftaran,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                    window.location.href="<?php echo site_url('login');?>";
                }else{
                    $('#errordiv').html('');
                    $('#errordiv').append(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
</script>
