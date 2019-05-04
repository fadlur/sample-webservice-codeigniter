<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12" id="divreport">
            <?php
            if ($itemunit->num_rows()!=null) {
                foreach ($itemunit->result() as $unit) {
                    ?>
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> <?php echo strtoupper($unit->unit) ?></h3>
                      </div>
                      <div class="panel-body">
                          <table class="table table-bordered table-striped">
                            <th>No</th>
                            <th>Output</th>
                            <th>Created</th>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($itemmonitor->result() as $monitor) {
                                    echo "<tr><td>";
                                    echo $no++;
                                    echo "</td><td>";
                                    echo $monitor->output;
                                    echo "</td><td>";
                                    echo date('d-m-Y H:i:s',strtotime($monitor->monitor_created));
                                    echo "</td></tr>";
                                }
                                 ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <?php
                }
            }else{
                redirect('member');
            }
             ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    setInterval(function(){ $('#divreport').load('<?php echo current_url()." #divreport > *" ?>'); }, 5000);
});
</script>
