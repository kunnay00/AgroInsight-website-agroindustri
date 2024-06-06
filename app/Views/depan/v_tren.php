<?php
if (!empty($record)) {
    foreach ($record as $key => $value) {
        // Misalnya, jika Anda ingin menampilkan hanya artikel dengan kategori tertentu (misalnya kategori 'berita')
        if ($value['post_category'] == "Tren Pasar") {
?>
            <div class="post-preview">
                <a href="<?php echo set_post_link($value['post_id'])?>">
                    <h2 class="post-title"><?php echo $value['post_title']?></h2>
                    <?php if($value['post_description']) { ?>
                        <h3 class="post-subtitle"><?php echo $value['post_description']?></h3>
                    <?php } ?>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#!"><?php echo $value['username']?></a>
                    on <?php echo $value['post_time']?>
                </p>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
<?php
        }
    }
} else {
    // Tampilkan pesan jika tidak ada artikel dengan kategori yang ditampilkan
    echo "Tidak ada artikel untuk ditampilkan dalam kategori ini.";
}
?>
<?php echo $pager->simpleLinks('ft','depan')?>
