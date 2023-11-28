<?php
require 'vendor/autoload.php';
require 'config.php';

try{
  $s3 = new Aws\S3\S3Client([
    'region'  => 'us-west-rack-2',
    'endpoint' => S3_URL,
    'use_path_style_endpoint' => true,
    'credentials' => [
      'key'    => S3_KEY,
      'secret' => S3_SECRET,
    ],
  ]);

  $nomeDoArquivoS3 = $_GET['arquivo'];

  // Faz downlod do arquivo do s3 / minio
  $retrive = $s3->getObject([
    'Bucket' => S3_BUCKET,
    'Key'    => $nomeDoArquivoS3
  ]);

  header('Content-Description: File Transfer');
  //this assumes content type is set when uploading the file.
  header('Content-Type: ' . $retrive->ContentType);
  header('Content-Disposition: attachment; filename=' . $nomeDoArquivoS3);
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  echo $retrive["Body"];

}catch(Exception $ex){
  echo "Erro > {$ex->getMessage()}";
}