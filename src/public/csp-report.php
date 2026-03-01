<?php
echo '<!doctype html>
<html lang="en">
  <head>
  <title>Test</title>
  </head>
  <body>
    <pre>';
if(isset($args['horwoodAuth']) && $args['horwoodAuth'] === 'HorwoodAuth'){

  if ($dir_handle = opendir('./logs')) {
    while (false !== ($entry = readdir($dir_handle))) {
      if ($entry != "." && $entry != "..") {
        echo "$entry\n";
        $handle = fopen("logs/$entry", "r");
        if ($handle) {
          while (($buffer = fgets($handle, 4096)) !== false) {
            print_r(json_decode($buffer));
          }
          fclose($handle);
        }
      }
    }
    closedir($dir_handle);
  }

}else{
  echo 'No auth token';
}
echo '  </body>
  </html>
</pre>';
