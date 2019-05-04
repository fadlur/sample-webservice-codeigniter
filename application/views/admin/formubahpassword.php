<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> User Profil</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input type="text" class="form-control" id="first_name" value="<?php echo $itemuser->first_name ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" class="form-control" id="last_name" value="<?php echo $itemuser->last_name ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo $itemuser->username ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">No Tlp</label>
                        <input type="text" class="form-control" id="phone" value="<?php echo $itemuser->phone ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" value="<?php echo $itemuser->email ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" placeholder="password baru">
                    </div>
                    <div class="form-group">
                        <label for="repeatpassword">Ulangi Password Baru</label>
                        <input type="password" class="form-control" id="repeatpassword" placeholder="ulangi password baru">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info" id="updateprofil" name="button"><span class="glyphicon glyphicon-edit"></span> Update Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','#updateprofil',updateprofil);
    function updateprofil(){
        var datauser = {'password':$('#password').val(),
        'repeatpassword':$('#repeatpassword').val()};console.log(datauser);
        $('#updateprofil').attr('disabled',true);
        $('#updateprofil').html('');
        $('#updateprofil').append('<span class="glyphicon glyphicon-refresh"></span> Updating');
        $.ajax({
            url : '<?php echo site_url("admin/dashboard/updatepassword") ?>',
            data : datauser,
            dataType : 'json',
            type : 'POST',
            timeout : 30000,
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                    resetbuttonupdate();
                    window.location.href="<?php echo site_url('logout') ?>";
                }else{
                    alert(data.msg);
                    resetbuttonupdate();
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                resetbuttonupdate();
            }
        })
    }
    function resetbuttonupdate() {
        $('#updateprofil').attr('disabled',false);
        $('#updateprofil').html('');
        $('#updateprofil').append('<span class="glyphicon glyphicon-edit"></span> Update');
    }
</script>
