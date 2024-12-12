<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-950 text-white">
    <nav class="bg-slate-900 text-white font-black text-3xl p-4 mb-3">
        <h1>package manager</h1>
    </nav>
    <div class="w-full">
        <span class="font-bold text-white" >return to home page <a href="index.php">click</a></span>
    </div>
    
    <footer class="absolute z-10 bottom-0">footer</footer>
</body>
</html>
<?php
$connection = new mysqli("localhost","root","","package_manager");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $title = $_POST["package"];
    $description = $_POST["descreption"];
    $author = $_POST["author"];
    $version = $_POST["version"];
    $email = $_POST["email"];
    $dependancie = $_POST["dependancie"];
    $tag_id = (int) $_POST["tag"];
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
    if($e_result->num_rows==0){
        $addautor->execute();
    };
    $package_id =  $t_result->fetch_assoc()["id"];
    $findversion= $connection->prepare("select * from versions where Version_Number like ?;");
    $findversion->bind_param("s",$version);
    $findversion->execute();
    $version_result= $findversion->get_result();
    $addversion = $connection->prepare("insert into versions (Version_Number,description,Release_Date,package_id) values(?,?,?,?);");
    
    $addversion->bind_param("sssi",$version,$description,$creation_date,$package_id);
    // dd($version_result->num_rows);
    if ($version_result->num_rows==0) {
        $addversion->execute();
    };
    $child_package_id = (int) $_POST["dependancie"];
    $dependencie= $connection->prepare("insert into Dependencies (parent_package_id,child_package_id) values(?,?);");
    $dependencie->bind_param("ii",$child_package_id,$package_id);
    $finddependencie= $connection->prepare("select * from Dependencies where child_package_id like ? and parent_package_id like ?;");
    $finddependencie->bind_param("ii",$child_package_id,$package_id);
    $finddependencie->execute();
    $result_d= $finddependencie->get_result();
    if($result_d->num_rows==0){
        $dependencie->execute();
    };
    $tag= $connection->prepare("insert into packages_tags (tag_id,package_id) values(?,?);");
    $tag->bind_param("ii",$tag_id,$package_id);
    $findtag= $connection->prepare("select * from packages_tags where tag_id like ? and package_id like ?;");
    $findtag->bind_param("ii",$tag_id,$package_id);
    $findtag->execute();
    $result_d= $findtag->get_result();
    if($result_d->num_rows==0){
        $tag->execute();
    };
    $author_id =  $e_result->fetch_assoc()["id"];
    $author_package_relation= $connection->prepare("insert into autors_packages (autor_id,package_id) values(?,?);");
    $author_package_relation->bind_param("ii",$author_id,$package_id);
    $findrelation= $connection->prepare("select * from autors_packages where package_id like ?;");
    $findrelation->bind_param("i",$package_id);
    $findrelation->execute();
    $relation_result= $findrelation->get_result();
    if($relation_result->num_rows==0 and $author_id){
        $author_package_relation->execute();
    };
}elseif ($_SERVER["REQUEST_METHOD"]=="GET") {
    if (isset($_GET["delete"])) {
        $packageDelete = (int) $_GET["delete"];
    };
    $delete= $connection->prepare("DELETE FROM packages_tags WHERE package_id = ?;");
    $delete->bind_param("i",$packageDelete);
    $delete->execute();
    $delete= $connection->prepare("DELETE FROM Dependencies WHERE child_package_id = ?;");
    $delete->bind_param("i",$packageDelete);
    $delete->execute();
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
<script>
    // Get the current reload count from sessionStorage, or initialize it as 0 if it doesn't exist
let reloadCount = sessionStorage.getItem("reloadCount") || 0;

function reloadPage() {
    reloadCount = parseInt(reloadCount);  // Ensure it's an integer

    // If the reload count is less than 3, reload the page instantly
    if (reloadCount < 3) {
        // Increment the reload count and save it back to sessionStorage
        reloadCount++;
        sessionStorage.setItem("reloadCount", reloadCount);

        // Reload the page instantly
        location.reload();
    }
}

// Start the reload process
reloadPage();

</script>