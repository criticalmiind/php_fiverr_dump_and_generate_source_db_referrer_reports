<?php
  function upload_as_a_base64($img_str='', $sub_dir='') {
    if($img_str == '' or !$img_str) return false;

    $target_dir='uploads/'.$sub_dir;
    $per = is_writable($target_dir);
    
    if($per){
      $image_parts = explode(";base64,", $img_str);
      if(count($image_parts) < 1) return false;

      $image_type_aux = explode("image/", $image_parts[0]);
      if(count($image_type_aux) < 2) return false;

      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);

      $file = $target_dir . uniqid() . '.png';
      file_put_contents($file, $image_base64);
      
      return $file;
    }else{
      return false;
    }
  }

  function get_as_base64($file)
  {
    if($file){
      $imagedata = file_get_contents($file);
      return "data:image/png;charset=utf-8;base64,".$base64 = base64_encode($imagedata);
    }else{
      return false;
    }
  }

?>