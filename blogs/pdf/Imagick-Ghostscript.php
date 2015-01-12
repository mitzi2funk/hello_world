<?php

//ImageMagic定義
$im = new imagick();
//$im->setResolution(144,144);

//対象のディレクトリを指定(カレントディレクトリ);
$serch_dir = dirname(__FILE__);

$files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($serch_dir,
                    FilesystemIterator::CURRENT_AS_FILEINFO |
                    FilesystemIterator::KEY_AS_PATHNAME |
                    FilesystemIterator::SKIP_DOTS
            )
        );

// 拡張子がpdfのファイルのみ抽出
$files = new RegexIterator($files, '/^.+\.pdf$/i', RecursiveRegexIterator::MATCH);

foreach($files as $file_path => $file_info) {
//    echo 'file name : '. basename($file_path)          .PHP_EOL; //ファイル名
//    echo 'file path : '. $file_path                    .PHP_EOL; //ファイルのフルパス
//    echo 'file size : '. $file_info->getSize()         .PHP_EOL; //ファイルサイズ
//    echo 'contents  : '. file_get_contents($file_path) .PHP_EOL; //ファイルの内容を取得
//    echo 'serch dir : '. $serch_dir                    .PHP_EOL; //

      //ファイル名のみ取得
      $file_name = basename($file_path);
      $reg="/(.*)(?:\.([^.]+$))/";
      preg_match($reg,$file_name,$retArr);
      $file_name  = $retArr[1];
      $extension  = $retArr[2];

      //ImageMagic処理
      //im->readimage($file_path);
      //$page_count = $im->getImageScene();

      //PDFから画像ファイルへの変換処理
      $output = shell_exec("convert ".$file_path." ".$serch_dir."/".$file_name.".png 2>&1");
      print_r ($output);

//      for($i = 0; $i <= $page_count-1; $i++) {
//          $im->setIteratorIndex($i);
//          $im->setImageFormat('png');
//          $im->writeimage($serch_dir.'/'.$file_name . $i . "png");
//      }

}

$im->clear();

?>
