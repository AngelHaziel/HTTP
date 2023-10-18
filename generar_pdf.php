<?php
   require('FPDF/fpdf.php');
   $id_compra = 12;
   $id_user = 1;
   $fpdf = new FPDF();
   $fpdf ->AddPage();
   $fpdf ->SetFont('arial','B',14);
   $fpdf ->Write(60,'Numero de compra: '.$id_compra);
   $fpdf ->Close();
   if (!is_dir('PDF/'.$id_user)) {
    if (mkdir('PDF/'.$id_user, 0777)) {
        $fpdf->Output('F','PDF/'.$id_user.'/compra_'.$id_compra.'.pdf');
    } else {
        echo "Hubo un error al crear la carpeta '$id_user'.";
    }
} else {
    $fpdf->Output('F','PDF/'.$id_user.'/compra_'.$id_compra.'.pdf');
}
$localFile = 'PDF/'.$id_user.'/compra_'.$id_compra.'.pdf';
$RemotePath = 'sftp://10.0.0.7/PDF/'.$id_user;
$localUrl = 'PDF/'.$id_user;
$remoteUrl = '10.0.0.7/PDF/'.$id_user;
if(copy($localUrl,$remoteUrl)){
    $options = array(
        CURLOPT_UPLOAD => true,
        CURLOPT_PROTOCOLS => CURLPROTO_SFTP,
        CURLOPT_USERPWD => 'root:1234' 
    );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_URL, $remotePath);
        curl_setopt($ch, CURLOPT_INFILE, fopen($localFile, 'r'));
            if (curl_exec($ch)) {
                echo 'Transferencia exitosa';
            } else {
                echo 'Error en la transferencia: ' . curl_error($ch);
            }
        curl_close($ch);
}


?>
