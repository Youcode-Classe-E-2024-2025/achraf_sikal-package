<?php include_once "helpers.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    table, th, td, input {
    border:1px solid black;
    }
    </style>
</head>
<body class="bg-sky-950 text-white">
    <nav class="bg-slate-900 text-white font-black text-3xl p-4 mb-3">
        <h1>package manager</h1>
    </nav>
    <div class="w-full">
        <button class="bg-blue-700 p-1 rounded-sm font-bold text-white hidden" onclick="document.getElementById('addform').classList.toggle('hidden'),this.classList.add('hidden'),this.nextElementSibling.classList.toggle('hidden')" >close</button>
        <button class="bg-blue-700 p-1 rounded-sm font-bold text-white" onclick="document.getElementById('addform').classList.toggle('hidden'),this.classList.add('hidden'),this.previousElementSibling.classList.toggle('hidden')" >add package</button>
    </div>
    <form id="addform" action="#" method="post" class="grid gap-1 hidden w-2/12">
        <label for="package">Package: </label>
        <input type="text" name="package" required>
        <label for="descreption">Descreption: </label>
        <input type="text" name="descreption" required>
        <label for="version">Version: </label>
        <input type="text" name="version" required>
        <label for="author">Your name: </label>
        <input type="name" name="author" required>
        <label for="email">Your E-mail: </label>
        <input type="email" name="email" required>
        <label for="tag">Tag: </label>
        <input type="text" name="tag" required>
        <label for="dependancie">Dependancie: </label>
        <input type="text" name="dependancie" required>
        <input type="submit">
    </form>
    <div id="php" class="mt-6 grid justify-items-center" style= "bg-red-600">
        <?php
        $connection = new mysqli("localhost","root","","package_manager");
        $stmt = $connection->prepare("select * from autors_packages  inner join autors on autors.id = autors_packages.autor_id inner join packages on packages.id = autors_packages.package_id;");
        $stmt->execute();
        $result = $stmt->get_result();
        // echo '<table class="bg-blue-100" style="width:80%">';
        while($row = $result->fetch_assoc()){
            echo '<div class="bg-slate-900 w-1/2 min-h-28 mb-3 border-sky-800 border flex align-middle transition-transform hover:scale-105">
                    <img src="package-x-generic.svg" alt="" width="80">
                    <div class="grid grid-cols-12 justify-between w-full">
                        <div class="col-span-11">
                            <h2 class="font-medium">',$row["title"],'</h2>
                            <p class="text-slate-400">',$row["description"],'</p>
                            <p class="text-slate-500">last updated: <span>',$row["creation_date"],'</span></p>
                            <p class="text-slate-500">author: <span>',$row["name"],'</span></p>
                            <p class="text-slate-500">current version: <span>1.0</span></p>
                        </div>
                        <form class="flex flex-col justify-center w-5" method="get">
                            <input type="hidden" id="delete" name="delete" value=',$row["id"],'>
                            <input type="image" class="align-middle" width="20px" src="download.svg" alt="Submit">
                        </form>
                    </div>
                </div>';
            // echo "<tr><td>",$row["title"],"</td><td>",$row["description"],"</td><td>",$row["name"]."</td><td>",$row["creation_date"]."</td></tr>";
        };
        // echo '</table>';
        ?>
    </div>
    
    <footer>footer</footer>
    <div class="">
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST"){
            $title = $_POST["package"];
            $description = $_POST["descreption"];
            $author = $_POST["author"];
            $version = $_POST["version"];
            $dependancie = $_POST["dependancie"];
            $tag = $_POST["tag"];
            $creation_date = DATE('Y-m-d');
            $addpackage= $connection->prepare("insert into packages (title,description,creation_date) values(?,?,?);");
            $addautor= $connection->prepare("insert into autors (name,email) values(?,?);");
            $addpackage->bind_param("sss",$title,$description,$creation_date);
            $addautor->bind_param("ss",$author,$email);
            $findtitle= $connection->prepare("select * from packages where title like ?;");
            $find_title= "%". $title ."%";
            $findtitle->bind_param("s",$find_title);
            $findtitle->execute();
            $t_result= $findtitle->get_result();
            if($t_result->num_rows==0){
                $addpackage->execute();
            };
            $findtitle->execute();
            $t_result= $findtitle->get_result();
            $findemail= $connection->prepare("select * from autors where email like ?;");
            $find_email= "%". $email ."%";
            $findemail->bind_param("s",$find_email);
            $findemail->execute();
            $e_result= $findemail->get_result();
            $author_id = $e_result->fetch_assoc()["id"];
            $package_id =  $t_result->fetch_assoc()["id"];
            if($e_result->num_rows==0){
                $addautor->execute();
            };
            $author_package_relation= $connection->prepare("insert into autors_packages (autor_id,package_id) values(?,?);");
            $author_package_relation->bind_param("ii",$author_id,$package_id);
            $findrelation= $connection->prepare("select * from autors_packages where package_id like ?;");
            $findrelation->bind_param("i",$package_id);
            $findrelation->execute();
            $relation_result= $findrelation->get_result();
            if($relation_result->num_rows==0){
                $author_package_relation->execute();
            };
            $findversion= $connection->prepare("select * from versions where Version_Number like ?;");
            $findversion->bind_param("s",$version);
            $findversion->execute();
            $version_result= $findversion->get_result();
            $addversion = $connection->prepare("insert into versions (Version_Number,description,Release_Date,package_id) values(?,?,?,?);");
            
            $addversion->bind_param("sssi",$version,$description,$creation_date,$package_id);
            // dd($version_result->num_rows);
            if ($version_result->num_rows==0) {
                $addversion->execute();
            }
        }elseif ($_SERVER["REQUEST_METHOD"]=="GET") {
            $packageDelete = (int) $_GET["delete"];
            $delete= $connection->prepare("DELETE FROM versions WHERE package_id = ?;");
            $delete->bind_param("i",$packageDelete);
            $delete->execute();
            $delete= $connection->prepare("DELETE FROM autors_packages WHERE package_id = ?;");
            $delete->bind_param("i",$packageDelete);
            $delete->execute();
            $delete= $connection->prepare("DELETE FROM packages WHERE id = ?;");
            $delete->bind_param("i",$packageDelete);
            $delete->execute();
        };
        ?>
    </div>
</body>
</html>