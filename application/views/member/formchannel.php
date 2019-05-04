<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Channel</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Channel</button>
                    <hr>
                    <?php
                    if ($itemunit->num_rows()!=null) {
                        $no = 1;
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <th>No</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Action</th>
                            <tbody id="daftarunit">
                                <?php
                                foreach ($itemunit->result() as $unit) {
                                    echo "<tr><td>";
                                    echo $no++;
                                    echo "</td><td>";
                                    echo $unit->unit;
                                    echo "</td><td>";
                                    switch ($unit->status) {
                                        case 1:
                                            echo "Monitoring";
                                            break;
                                        case 2:
                                            echo "Kontrol Toggle";
                                            break;
                                        case 3:
                                            echo "Kontrol Variable";
                                            break;

                                        default:
                                            echo "";
                                            break;
                                    }
                                    echo "</td><td>";
                                    echo '<button class="btn btn-info" id="samplecode" data-key="'.$unit->api_key.'" data-idunit="'.$unit->id_unit.'" title="Sample Code Arduino" data-toggle="modal" data-target="#sampleModal"><span class="glyphicon glyphicon-copy"></span> Code</button> ';
                                    echo '<button class="btn btn-primary" id="editunit" name="editunit'.$unit->id_unit.'" data-idunit="'.$unit->id_unit.'" title="Edit nama unit" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-edit"></span> Edit</button> ';
                                    echo '<button class="btn btn-danger" id="hapusunit" name="hapusunit'.$unit->id_unit.'" data-idunit="'.$unit->id_unit.'" title="Hapus nama unit"><span class="glyphicon glyphicon-trash"></span> Delete</button>';
                                    echo "</td></tr>";
                                }
                                 ?>
                            </tbody>
                           </table>
                    </div>
                    <?php
                    }
                     ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="dashboard">
        <?php
            if ($itemunit->num_rows()!=null) {
                foreach ($itemunit->result() as $unit) {
        ?>
        <?php
            if ($unit->status==1) {
                echo '<div class="col-md-4 col-sm-4" id="divmonitoring'.$unit->id_unit.'">';
            }else{
                echo '<div class="col-md-4 col-sm-4">';
            }
         ?>

            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> <?php echo ucwords($unit->unit); ?></h3>
              </div>
              <div class="panel-body" id="detailoutput<?php echo $unit->id_unit;?>">
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered">
                          <th>Unit</th>
                          <th>Output</th>
                          <th>Waktu</th>
                          <tbody>
                              <?php
                              $lastoutput = 0;
                              foreach ($itemmonitor->result() as $monitor) {
                                  if ($monitor->unit_id == $unit->id_unit) {
                                      echo "<tr><td>";
                                      echo $unit->unit;
                                      echo "</td><td>";
                                      echo $monitor->output;
                                      echo "</td><td>";
                                      echo $monitor->monitor_created;
                                      echo "</td></tr>";
                                      $lastoutput = $monitor->output;
                                      break;
                                  }
                              }
                               ?>
                          </tbody>
                      </table>
                  </div>
                  <?php switch ($unit->status) {
                      case 1:
                          echo '<div class="alert alert-warning">Monitoring output '.strtolower($unit->unit).'</div>';
                          break;
                      case 2:
                            if ($lastoutput==0) {
                                echo '<button class="btn btn-danger" data-idunit="'.$unit->id_unit.'" data-output="1" data-key="'.$unit->api_key.'" id="togglebutton" title="Klik untuk menyalakan"><span class="glyphicon glyphicon-bell"></span> OFF</button>';
                            }else if ($lastoutput==1){
                                echo '<button class="btn btn-success" data-idunit="'.$unit->id_unit.'" data-output="0" data-key="'.$unit->api_key.'" id="togglebutton" title="Klik untuk mematikan"><span class="glyphicon glyphicon-bell"></span> ON</button>';
                            }else{
                                echo '<button class="btn btn-danger" data-idunit="'.$unit->id_unit.'" data-output="1" data-key="'.$unit->api_key.'" id="togglebutton" title="Klik untuk menyalakan"><span class="glyphicon glyphicon-bell"></span> OFF</button>';
                            }
                          break;
                      case 3:
                          echo "<div class='row'>";
                          echo "<div class='col-md-6 col-sm-6'>";
                          echo "<input class='form-control' name='output".$unit->id_unit."' id='output'>";
                          echo "</div>";
                          echo "<div class='col-md-6 col-sm-6'>";
                          echo '<button class="btn btn-warning" data-idunit="'.$unit->id_unit.'" data-key="'.$unit->api_key.'" id="simpanoutput" title="Klik untuk menyimpan perintah"><span class="glyphicon glyphicon-save"></span> SIMPAN</button>';
                          echo "</div>";
                          echo "</div>";
                          break;

                      default:
                          echo "";
                          break;
                  } ?>
                  <hr>
                  <a href="<?php echo site_url('member/channel/report').'/'.$unit->id_unit?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-th-list"></span> Report</a>
              </div>
            </div>
        </div>
        <?php
                }
            }
         ?>
    </div>
</div>
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Modal</h4>
      </div>
      <div class="modal-body">
        <form class="#">
            <div class="form-group">
              <label for="unit">Channel</label>
              <input type="text" class="form-control" id="unit" placeholder="">
              <input type="hidden" name="id_unit" value="" id="id_unit">
            </div>
            <div class="form-group">
              <label for="unit">Status</label>
              <select class="form-control" name="status" id="status">
                  <option value="1">Monitoring</option>
                  <option value="2">Kendali Toggle</option>
                  <option value="3">Kendali Variable</option>
              </select>
              <p class="help-block">*Monitoring hanya digunakan untuk monitoring</br>
              *Kendali Toggle kendali dengan mode on/off</br>
              *Kendali Variable kendali semacam slider</p>
            </div>
            <div class="form-group">
                <button type="button" name="simpanunit" id="simpanunit" class="btn btn-primary">Simpan</button>
                <button type="button" name="resetunit" id="resetunit" class="btn btn-warning">Reset</button>
                <button type="button" name="updateunit" id="updateunit" class="btn btn-info" disabled="true">Update</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--modal sample code-->
<div class="modal fade" id="sampleModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""><span class="glyphicon glyphicon-barcode"></span> API KEY</h4>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-striped">
              <th>ID</th>
              <th>API</th>
              <th>Sample Code</th>
              <tbody id="apikeymodal">

              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--end modal sample code-->
<script>
    $(document).ready(function(){
        //setInterval(function(){ $('.divmonitoring').load('<?php echo current_url()." .divmonitoring > *" ?>'); }, 3000);

        setInterval(function(){
        $.ajax({
            url : '<?php echo site_url("member/channel/loadmonitoring")?>',
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $.each(data.unit,function(k,v){
                        if (v['status']==1) {
                            console.log(v['id_unit']);
                            $('#divmonitoring'+v['id_unit']).load('<?php echo current_url()." #divmonitoring" ?>'+v['id_unit']+' > *');
                        }
                    })
                }else{
                    console.log(data.msg);
                }
            }
        })
    },3000);

    });
    $(document).on('click','#simpanunit',simpanunit)
    .on('click','#resetunit',resetunit)
    .on('click','#hapusunit',hapusunit)
    .on('click','#editunit',editunit)
    .on('click','#updateunit',updateunit)
    .on('click','#togglebutton',togglebutton)
    .on('click','#simpanoutput',simpanoutput)
    .on('click','#samplecode',samplecode);
    function simpanunit(e){
        e.preventDefault();
        $('#simpanunit').attr('disabled',true);
        $('#simpanunit').html('');
        $('#simpanunit').html('<span class="glyphicon glyphicon-refresh"></span> Menyimpan');
        var dataunit = {'unit':$('#unit').val(),
        'status':$('#status').val()}
        $.ajax({
            url : '<?php echo site_url("member/channel/create")?>',
            data : dataunit,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    resetbuttonsimpan();
                    resetunit(e);
                    $('#myModal').modal('toggle');
                    $('#dashboard').load('<?php echo current_url()." #dashboard > *" ?>');
                    $('#daftarunit').load('<?php echo current_url()." #daftarunit > *" ?>');
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resetbuttonsimpan(){
        $('#simpanunit').attr('disabled',false);
        $('#simpanunit').html('');
        $('#simpanunit').html('Simpan');
    }
    function resetbuttonupdate(){
        $('#updateunit').attr('disabled',false);
        $('#updateunit').html('');
        $('#updateunit').html('update');
    }
    function resetbuttondelete(id){
        $('button[name=deleteunit'+id+']').attr('disabled',false);
        $('button[name=deleteunit'+id+']').html('');
        $('button[name=deleteunit'+id+']').html('<span class="glyphicon glyphicon-trash"></span> Delete');
    }
    function resetunit(e){
        e.preventDefault();
        resetbuttonsimpan();
        $('#unit').val('');
        $('#id_unit').val('');
        $('#simpanunit').attr('disabled',false);
        $('#updateunit').attr('disabled',true);
    }
    function editunit(e){
        e.preventDefault();
        var dataunit = {'id_unit':$(this).data('idunit')}
        $.ajax({
            url : '<?php echo site_url("member/channel/edit")?>',
            data : dataunit,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $.each(data.unit,function(k,v){
                        console.log(k,v);
                        $('#id_unit').val(v['id_unit']);
                        $('#unit').val(v['unit']);
                        $('#status').val(v['status']);
                    })
                    $('#simpanunit').attr('disabled',true);
                    $('#updateunit').attr('disabled',false);
                }else{
                    alert(data.msg);
                    $('#myModal').modal('toggle');
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('#myModal').modal('toggle');
            }
        })
    }
    function updateunit(e){
        e.preventDefault();
        $('#updateunit').attr('disabled',true);
        $('#updateunit').html('');
        $('#updateunit').html('<span class="glyphicon glyphicon-refresh"></span> Mengupdate');
        var dataunit = {'id_unit':$('#id_unit').val(),
            'unit':$('#unit').val(),
        'status':$('#status').val()}
        $.ajax({
            url : '<?php echo site_url("member/channel/update")?>',
            data : dataunit,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    resetbuttonupdate();
                    resetunit(e);
                    $('#myModal').modal('toggle');
                    $('#dashboard').load('<?php echo current_url()." #dashboard > *" ?>');
                    $('#daftarunit').load('<?php echo current_url()." #daftarunit > *" ?>');
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function hapusunit(e){//delete unit
        e.preventDefault();
        if (confirm("Menghapus unit akan menghapus data monitoring juga, anda yakin?")) {
            var id = $(this).data('idunit');
            $('button[name=deleteunit'+id+']').attr('disabled',true);
            $('button[name=deleteunit'+id+']').html('');
            $('button[name=deleteunit'+id+']').html('<span class="glyphicon glyphicon-refresh"></span> Menghapus');
            var dataunit = {'id_unit':$(this).data('idunit')}
            $.ajax({
                url : '<?php echo site_url("member/channel/delete")?>',
                data : dataunit,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        resetbuttondelete();
                        $('#dashboard').load('<?php echo current_url()." #dashboard > *" ?>');
                        $('#daftarunit').load('<?php echo current_url()." #daftarunit > *" ?>');
                    }else{
                        alert(data.msg);
                    }
                },
                error : function(x,t,m){
                    alert(x.responseText);
                }
            })
        }
    }
    function samplecode(){
        var key = $(this).data('key');
        var id = $(this).data('idunit');
        var status = $(this).data('status');
        $('#apikeymodal').html('');
        $('#apikeymodal').append("<tr><td>"+id+"</td><td>"+key+"</td><td><a href='https://drive.google.com/open?id=0B_pqD5Px1En2b2RiVE1xU1dDdUk' alt='sample code'><span class='glyphicon glyphicon-download'></span></a></td></tr>");
    }
    //button
    function togglebutton(){
        var id = $(this).data('idunit');
        var key = $(this).data('key');
        var output = $(this).data('output');
        var dataoutput = {'id_unit':id,
        'api_key':key,
        'output':output};
        console.log(dataoutput);
        $('#togglebutton').attr('disabled',true);
        $.ajax({
            url : "<?php echo site_url('member/channel/createoutput')?>",
            data : dataoutput,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                    $('#detailoutput'+id).load('<?php echo current_url();?> #detailoutput'+id+' > *');
                    $('#togglebutton').attr('disabled',false);
                }else{
                    alert(data.msg);
                    $('#togglebutton').attr('disabled',false);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('#togglebutton').attr('disabled',false);
            }
        })
    }
    function simpanoutput(){
        var id = $(this).data('idunit');
        var key = $(this).data('key');
        var output = $('#output').val();
        var dataoutput = {'id_unit':id,
        'api_key':key,
        'output':output};
        console.log(dataoutput);
        $('#simpanoutput').attr('disabled',true);
        $.ajax({
            url : "<?php echo site_url('member/channel/createoutput')?>",
            data : dataoutput,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                    $('#detailoutput'+id).load('<?php echo current_url();?> #detailoutput'+id+' > *');
                    $('#simpanoutput').attr('disabled',false);
                }else{
                    alert(data.msg);
                    $('#simpanoutput').attr('disabled',false);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('#simpanoutput').attr('disabled',false);
            }
        })
    }
</script>
