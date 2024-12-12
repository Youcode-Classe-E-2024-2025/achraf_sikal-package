<?php include_once "helpers.php";
?>
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
    <form id="addform" action="data.php" method="post" class="grid gap-1 hidden w-2/12">
        <label for="package">Package: </label>
        <input type="text" name="package" class="text-black" required>
        <label for="descreption">Descreption: </label>
        <input type="text" name="descreption" class="text-black" required>
        <label for="version">Version: </label>
        <input type="text" pattern="^(?:(\d+)\.)?(?:(\d+)\.)?(\*|\d+)$" name="version" class="text-black" required>
        <label for="author">Your name: </label>
        <input type="name" name="author" class="text-black" required>
        <label for="email">Your E-mail: </label>
        <input type="email" name="email" class="text-black" required>
        <label for="tag">Tag: </label>
        <select name="tag" id="tag" class="text-black">
            <?php
            $connection = new mysqli("localhost","root","","package_manager");
            $stmt = $connection->prepare("select * from tags;");
            $stmt->execute();
            $result = $stmt->get_result();
            while($rows = $result->fetch_assoc()){
                echo '<option value=',$rows["id"],'>',$rows["name"],'</option>';
            };
            ?>
        </select>
        <label for="dependancie">Dependancie: </label>
        <select name="dependancie" id="dependancie" class="text-black">
            <?php
            $connection = new mysqli("localhost","root","","package_manager");
            $stmt = $connection->prepare("select autors.name,autors.email, packages.title,packages.creation_date,packages.description,packages.id,versions.Version_Number,release_date from autors_packages  inner join autors on autors.id = autors_packages.autor_id  inner join packages on packages.id = autors_packages.package_id inner join versions on versions.package_id = autors_packages.package_id WHERE release_date IN(SELECT max(release_date) FROM versions GROUP BY package_id) ORDER BY release_date DESC;");
            $stmt->execute();
            $result = $stmt->get_result();
            while($rows = $result->fetch_assoc()){
                echo '<option value=',$rows["id"],'>',$rows["title"],'</option>';
            };
            ?>
        </select>
        <input type="submit">
    </form>
    <div id="php" class="mt-6 grid justify-items-center" style= "bg-red-600">
        <?php
        $connection = new mysqli("localhost","root","","package_manager");
        $stmt = $connection->prepare("select autors.name,autors.email, packages.title,packages.creation_date,packages.description,packages.id,versions.Version_Number,release_date from autors_packages  inner join autors on autors.id = autors_packages.autor_id  inner join packages on packages.id = autors_packages.package_id inner join versions on versions.package_id = autors_packages.package_id WHERE release_date IN(SELECT max(release_date) FROM versions GROUP BY package_id) ORDER BY release_date DESC;");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            echo '<div class="bg-slate-900 w-1/2 min-h-28 mb-3 border-sky-800 border flex align-middle transition-transform hover:scale-105">
                    <img src="./assets/images/package-x-generic.svg" alt="" width="80">
                    <div class="grid grid-cols-12 justify-between w-full">
                        <div class="col-span-11">
                            <h2 class="font-medium">',$row["title"],'</h2>
                            <p class="text-slate-400">',$row["description"],'</p>
                            <div class= "flex gap-5 text-xs">
                                <p class="text-slate-500">creation date: <span>',$row["creation_date"],'</span></p>
                                <p class="text-slate-500">last updated: <span>',$row["release_date"],'</span></p>
                            </div>
                            <p class="text-slate-500">author: <span>',$row["name"],'</span></p>
                            <p class="text-slate-500">current version: <span>',$row["Version_Number"],'</span></p>
                        </div>
                        <form class="flex flex-col justify-center w-5" method="get">
                            <input type="hidden" id="delete" name="delete" value=',$row["id"],'>
                            <input type="image" class="align-middle" width="20px" src="./assets/images/trash-solid.svg" alt="Submit">
                        </form>
                    </div>
                </div>';
            // echo "<tr><td>",$row["title"],"</td><td>",$row["description"],"</td><td>",$row["name"]."</td><td>",$row["creation_date"]."</td></tr>";
        };
        // echo '</table>';
        ?>
    </div>
    <div>
        <?php
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
        ?>
    </div>
    <footer>footer</footer>
    <script>sessionStorage.setItem("reloadCount", 0);</script>
</body>
</html>