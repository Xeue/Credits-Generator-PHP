<?php

if (isset($_FILES['images'])) {
  $project = $_POST['project'];

  if ($_POST['new'] == "true") {
    $path = "saves/$project";
    $data = 'var credits = [
    	{
    		"spacing": "8",
    		"imageHeight": "24",
    		"image": "../../../assets/Placeholder.jpg",
    		"title": "Placeholder",
    		"subTitle": "Placeholder",
    		"text": "Placeholder",
    		"maxColumns": "2",
    		"columns": [
    			{
    				"title": "Column 1"
    			},
    			{
    				"title": "Column 2"
    			}
    		],
    		"names": [
    			{
    				"role": "Role",
    				"name": "Name"
    			},
    			"Name 2"
    		]
    	}
    ]';
    file_put_contents("1.js", $data);
    echo '{"type":"success", "new":true, "project":"'.$project.'"}';
  } else {
    echo '{"type":"success", "new":false}';
  }

  $projPath = "saves/$project/logo/";
  mkdir($projPath);

  $images = $_FILES['images'];
  $fileCount = count($images["name"]);

  for ($i = 0; $i < $fileCount; $i++) {
    $file = $images["tmp_name"][$i];
    $name = $images["name"][$i];
    move_uploaded_file($file, $projPath.$name);
  }
}

?>
