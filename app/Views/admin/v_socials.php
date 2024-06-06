

<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <?php echo $templateJudul?>
</div>
<div class="card-body">
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
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="input_set_socials_x" class="form-label">X</label>
            <input type="text" class="form-control" id="input_set_socials_x" name="set_socials_x" value="<?php echo(isset($set_socials_x)) ? $set_socials_x : "" ?>">
        </div>
        <div class="mb-3">
            <label for="input_set_socials_fb" class="form-label">Facebook</label>
            <input type="text" class="form-control" id="input_set_socials_fb" name="set_socials_fb" value="<?php echo(isset($set_socials_fb)) ? $set_socials_fb : "" ?>">
        </div>
        <div class="mb-3">
            <label for="input_set_socials_wa" class="form-label">WhatsApp</label>
            <input type="text" class="form-control" id="input_set_socials_wa" name="set_socials_wa" value="<?php echo(isset($set_socials_wa)) ? $set_socials_wa : "" ?>">
        </div>
        <div>
            <input type="submit" name="submit" value="Simpan" class="btn btn-primary float-end">
        </div>
    </form>
</div>

                        
