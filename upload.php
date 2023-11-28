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
  
  if (!isset($_FILES['file'])) {
    throw new Exception("File not uploaded", 1);
  }
  
  $file = $_FILES['file'];

  $extesaoOriginalDoArquivo = pathinfo($file['name'], PATHINFO_EXTENSION);
  $nomeDoArquivoS3 = time(). '.'.  $extesaoOriginalDoArquivo;
  
  //Envia para s3 / minio
  $insert = $s3->putObject([
    'Bucket'            => S3_BUCKET,
    'Key'               => $nomeDoArquivoS3, // Nome
    'SourceFile'        => $file['tmp_name'], // Nome temporario para enviar arquivo
    'ContentType'       => $file['type']
  ]);
  
  echo '<a href="download.php?arquivo='. $nomeDoArquivoS3 .'">Download</a>';

}catch(Exception $ex){
  echo "Erro > {$ex->getMessage()}";
}