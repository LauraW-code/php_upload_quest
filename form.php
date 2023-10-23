<?php

$errors = [];
$uploadDir = 'public/uploads/';

if($_SERVER["REQUEST_METHOD"] === "POST") {
     
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];

    $maxFileSize = 1048576;

    $data = array_map('trim', $_POST);
    $data = array_map('htmlentities', $data);

    if( (!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Png, Gif ou Webp';
    }
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = 'Votre fichier doit faire moins de 1M!';
    }
    if(!isset($data['lastname']) || empty($data['lastname'])) {
        $errors[] = 'Le nom est obligatoire';
    }
    if(!isset($data['firstname']) || empty($data['firstname'])) {
        $errors[] = 'Le prénom est obligatoire';
    }
    if(!isset($data['age']) || empty($data['age'])) {
        $errors[] = 'L\'age est obligatoire';
    }

    if(!empty($errors)){
        foreach($errors as $error){
            echo $error . '<br>';
        }   
    }
    else{
        $uniqueFileName = uniqid('image_') . '.' . $extension;
        $uploadFile = $uploadDir .$uniqueFileName;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        echo 'Firstname: ' . $data['firstname'] . '<br>' . 'Lastname: ' . $data['lastname'] . '<br>' . 'Age: ' . $data['age'] . '<br>';
        echo '<img src="public/uploads/'.$uniqueFileName.'">';     
    }
}

?>

<form method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload a profile image</label>
    <br>    
    <input type="file" name="avatar" id="imageUpload" />
    <br> 
    <br> 

    <label for="firstname">Insert your firstname</label>    
    <br> 
    <input type="text" name="firstname" id="firstname" />
    <br> 
    <br> 

    <label for="lastname">Insert your lastname</label>  
    <br>   
    <input type="text" name="lastname" id="lastname" />
    <br> 
    <br> 

    <label for="age">Insert your age</label> 
    <br>    
    <input type="text" name="age" id="age" />
    <br> 
    <br> 

    <button name="send">Send</button>
</form>

<hr>

