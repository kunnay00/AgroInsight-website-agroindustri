
                        <!-- <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Primary Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Warning Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Success Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Danger Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div> -->
<?php
$halaman = "artikel";
?>

<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <?php echo $templateJudul?> 
</div>
<div class="card-body">
    <div class="row mb-3">
        <div class="col-lg-3 pt-1 pb-1">
            <form action="" method="GET">
                <input type="text" placeholder="Cari..." name="katakunci" class="form-control" value="<?php echo $katakunci?>">
            </form>
        </div>
        <div class="col-lg-9 pt-1 pb-1 text-end">
            <a href="<?php echo site_url("admin/$halaman/tambahartikel")?>" class="btn btn-xl btn-primary">+ Tambah</a>
        </div>
    </div>
    <?php
    $session = \Config\Services::session();
    if($session->getFlashdata('warning')){
    ?>
        <div class="alert alert-warning">
            <ul>
                <?php
                foreach ($session->getFlashdata('warning') as $val) {
                ?>
                    <li><?php echo $val ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php    
    }
    if($session->getFlashdata('success')) {
    ?>
        <div class="alert alert-success"><?php echo $session->getFlashdata('success')?>
        </div>
    <?php    
    }
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-1">No.</th>
                <th class="col-6">Judul</th>
                <th class="col-3">Tanggal</th>
                <th class="col-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($record as $value){
                $post_id = $value['post_id'];
                $link_edit = site_url("admin/$halaman/editartikel/$post_id");
                $link_delete = site_url("admin/$halaman/?aksi=hapus&post_id=$post_id");
            ?>
                <tr>
                    <td><?php echo $nomor?></td>
                    <td><?php echo $value['post_title']?></td>
                    <td><?php echo $value['post_time']?></td>
                    <td>
                        <a href='<?php echo $link_edit ?>' class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?php echo $link_delete ?>" onclick="return confirm('Apakah anda yakin akan menghapus artikel ini?')" class="btn btn-sm btn-danger">Del</a>
                    </td>
                </tr>
            <?php
                $nomor++;
            }
            ?>
        </tbody>
    </table>
    <?php echo $pager->links('dt', 'datatable')?>
</div>

                        
