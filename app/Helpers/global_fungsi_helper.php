<?php
function kirim_email($attachment,$to,$title,$messege) 
{
    $email = \Config\Services::email();
    $email_pengirim = EMAIL_ALAMAT;
    $email_nama = EMAIL_NAMA;

    $config['protocol'] = "smtp";
    $config['SMTPHost'] = "smtp.gmail.com";
    $config['SMTPUser'] = $email_pengirim;
    $config['SMTPPass'] = EMAIL_PASSWORD;
    $config['SMTPPort'] = 465;
    $config['SMTPCrypto'] = "ssl";
    $config['mailType'] = "html";

    $email->initialize($config);
    $email->setFrom($email_pengirim, $email_nama);
    $email->setTo($to);

    if ($attachment) {
        $email-attach($attachment);
    }

    $emai->setSubject($title);
    $email->setMessege($messege);

    if(!$emai->send()) {
        return  false;
    } else {
        return true;
    }
}

function nomor($currentPage, $jumlahBaris)
{
    if (is_null($currentPage)) {
        $nomor = 1;
    }else{
        $nomor = 1 + ($jumlahBaris * ($currentPage - 1));
    }
    return $nomor;
}

function purify($dirty_html)
{
    $config = HTMLPurifier_Config::createDefault();
    $config->set('URI.AllowedSchemes', array('data' => true));
    $purifier = new HTMLPurifier($config);
    $clean_html = $purifier->purify($dirty_html);
    return $clean_html;
}

function konfigurasi_get($konfigurasi_name)
{
    $model = new \App\Models\KonfigurasiModel;
    $filter = [
        'konfigurasi_name' => $konfigurasi_name
    ];
    $data= $model->getData($filter);
    return $data;
}

function konfigurasi_set($konfigurasi_name, $data_baru)
{
    $model = new \App\Models\KonfigurasiModel;
    $dataGet = konfigurasi_get($konfigurasi_name);
    $dataUpdate = [
        'id' =>$dataGet['id'],
        'konfigurasi_name' => $konfigurasi_name,
        'konfigurasi_value' => $data_baru['konfigurasi_value']
    ];
    $model->updateData($dataUpdate);
}

function set_post_link($post_id)
{
    $model = new \App\Models\PostsModel;
    $data = $model->getPost($post_id);
    $type = $data['post_type'];
    $jenis = $data['post_category'];
    $seo = $data['post_title_seo'];
    return site_url($type . "/" . $seo);
}

?>