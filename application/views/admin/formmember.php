<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> Form Member</h3>
                  </div>
              <div class="panel-body">
                  <form action="#">
                      <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input type="text" class="form-control" id="first_name" placeholder="nama depan">
                      </div>
                      <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" class="form-control" id="last_name" placeholder="nama belakang">
                      </div>
                      <div class="form-group">
                        <label for="phone">Tlp</label>
                        <input type="text" class="form-control" id="phone" placeholder="ketik no tlp">
                      </div>
                      <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" name="username" value="" class="form-control" id="username" placeholder="ketik username">
                          <input type="hidden" name="id_user" value="" id="id_user">
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="ketik password">
                      </div>
                      <div class="form-group">
                          <button type="button" name="simpanuser" id="simpanuser" class="btn btn-primary">Simpan</button>
                          <button type="button" name="resetuser" id="resetuser" class="btn btn-warning">Reset</button>
                          <button type="button" name="updateuser" id="updateuser" class="btn btn-info" disabled="true">Update</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-6">
            <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Daftar Member</h3>
                  </div>
              <div class="panel-body">
                  <table class="table table-striped">
                      <th>No</th>
                      <th>Nama</th>
                      <th>Tlp</th>
                      <th>Username</th>
                      <th></th>
                      <tbody id="daftaruser">
                          <?php
                          $no = 1;
                          foreach ($itemmember as $user) {
                              echo '<tr id="daftaruser'.$user->id.'">';
                              echo '<td>';
                              echo $no++;
                              echo '</td>';
                              echo '<td>';
                              echo $user->first_name." ".$user->last_name;
                              echo '</td>';
                              echo '<td>';
                              echo $user->phone;
                              echo '</td>';
                              echo '<td>';
                              echo $user->username;
                              echo '</td>';
                              echo '<td>';
                              echo '<button type="button" name="edituser" data-iduser="'.$user->id.'" id="edituser" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span></button> ';
                              echo '<button type="button" name="deleteuser" data-iduser="'.$user->id.'" id="deleteuser" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span></button>';
                              echo '</td>';
                              echo '</tr>';
                          } ?>
                      </tbody>
                  </table>
              </div>
        </div>
    </div>
</div>
<script>
$(document).on('click','#simpanuser',simpanuser)
.on('click','#edituser',edituser)
.on('click','#deleteuser',deleteuser)
.on('click','#resetuser',resetuser)
.on('click','#updateuser',updateuser)
.on('click','#cariuser',cariuser);
function simpanuser(e){
    e.preventDefault();
    var datauser = {'first_name':$('#first_name').val(),
    'last_name':$('#last_name').val(),
    'phone':$('#phone').val(),
    'username':$('#username').val(),
    'password':$('#password').val()};console.log(datauser);
    $('#simpanuser').attr('disabled',true);
    $('#simpanuser').html('');
    $('#simpanuser').append('<span class="glyphicon glyphicon-refresh"></span> Simpan');
    $.ajax({
        url : '<?php echo site_url("admin/dashboard/create") ?>',
        data : datauser,
        dataType : 'json',
        type : 'POST',
        timeout : 30000,
        success : function(data,status){
            if (data.status!='error') {
                alert(data.msg);
                resetuser(e);
                resetbuttonsimpan();
                $('#daftaruser').load('<?php echo current_url()." #daftaruser > *" ?>');
            }else{
                alert(data.msg);
                resetbuttonsimpan();
            }
        },
        error : function(x,t,m){
            alert(x.responseText);
            resetbuttonsimpan();
        }
    })
}
function edituser(){
    var datauser = {'id':$(this).data('iduser')};
    var id = $(this).data('iduser');console.log(datauser);
    $('button[name=edituser'+id+']').attr('disabled',true);
    $('button[name=edituser'+id+']').html('');
    $('button[name=edituser'+id+']').append('<span class="glyphicon glyphicon-refresh"></span>');
    $.ajax({
        url : '<?php echo site_url("admin/dashboard/edit") ?>',
        data : datauser,
        dataType : 'json',
        type : 'POST',
        timeout : 30000,
        success : function(data,status){
            if (data.status!='error') {
                alert(data.msg);
                $(window).scrollTop($('body').offset().top);
                $('#id_user').val(data.user['id']);
                $('#first_name').val(data.user['first_name']);
                $('#last_name').val(data.user['last_name']);
                $('#username').val(data.user['username']);
                $('#phone').val(data.user['phone']);
                $('#simpanuser').attr('disabled',true);
                $('#updateuser').attr('disabled',false);
                resetbuttonedit(id);
            }else{
                alert(data.msg);
                resetbuttonedit(id);
            }
        },
        error : function(x,t,m){
            alert(x.responseText);
            resetbuttonedit(id);
        }
    })
}
function deleteuser(){
    var datauser = {'id':$(this).data('iduser')};
    var id = $(this).data('iduser');
    if (confirm("Anda yakin akan menghapus data petugas?")) {
        $('button[name=deleteuser'+id+']').attr('disabled',true);
        $('button[name=deleteuser'+id+']').html('');
        $('button[name=deleteuser'+id+']').append('<span class="glyphicon glyphicon-refresh"></span>');
        $.ajax({
            url : '<?php echo site_url("admin/dashboard/delete") ?>',
            data : datauser,
            dataType : 'json',
            type : 'POST',
            timeout : 30000,
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                    $('#daftaruser'+id).fadeOut(200);
                    $('#daftaruser').load('<?php echo current_url()." #daftaruser > *" ?>');
                    resetbuttondelete(id);
                }else{
                    alert(data.msg);
                    resetbuttondelete(id);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                resetbuttondelete(id);
            }
        })
    }
}
function cariuser(){
    var datauser = {'keyworduser':$('#keyworduser').val()};
    console.log(datauser);
}
function resetuser(e){
    e.preventDefault();
    $('#id_user').val('');
    $('#first_name').val('');
    $('#last_name').val('');
    $('#password').val('');
    $('#phone').val('');
    $('#username').val('');
    $('#simpanuser').attr('disabled',false);
    $('#updateuser').attr('disabled',true);
}
function updateuser(e){
    var datauser = {'first_name':$('#first_name').val(),
    'last_name':$('#last_name').val(),
    'phone':$('#phone').val(),
    'username':$('#username').val(),
    'password':$('#password').val(),
    'id_user':$('#id_user').val()};console.log(datauser);
    $('#updateuser').attr('disabled',true);
    $('#updateuser').html('');
    $('#updateuser').append('<span class="glyphicon glyphicon-refresh"></span> Update');
    $.ajax({
        url : '<?php echo site_url("admin/dashboard/update") ?>',
        data : datauser,
        dataType : 'json',
        type : 'POST',
        timeout : 30000,
        success : function(data,status){
            if (data.status!='error') {
                alert(data.msg);
                resetuser(e);
                resetbuttonupdate();
                $('#simpanuser').attr('disabled',false);
                $('#updateuser').attr('disabled',true);
                $('#daftaruser').load('<?php echo current_url()." #daftaruser > *" ?>');
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
//reset button
function resetbuttonsimpan(){
    $('#simpanuser').attr('disabled',false);
    $('#simpanuser').html('');
    $('#simpanuser').append('Simpan');
}
function resetbuttonupdate(){
    $('#updateuser').attr('disabled',false);
    $('#updateuser').html('');
    $('#updateuser').append('Update');
}
function resetbuttonedit(id){
    $('button[name=edituser'+id+']').attr('disabled',false);
    $('button[name=edituser'+id+']').html('');
    $('button[name=edituser'+id+']').append('<span class="glyphicon glyphicon-edit"></span>');
}
function resetbuttondelete(id){
    $('button[name=deleteuser'+id+']').attr('disabled',false);
    $('button[name=deleteuser'+id+']').html('');
    $('button[name=deleteuser'+id+']').append('<span class="glyphicon glyphicon-edit"></span>');
}
</script>
