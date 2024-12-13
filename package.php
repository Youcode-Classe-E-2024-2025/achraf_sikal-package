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
        <a href="index.php">package manager</a>
    </nav>
    <div id="php" class="mt-6 grid justify-items-center" style= "bg-red-600">
        <?php
        $details = (int) $_GET["details"];
        $connection = new mysqli("localhost","root","","package_manager");
        // $sql = "select autors.name,autors.email, tags.name as tag_name, dependencies.parent_package_id, packages.title,packages.creation_date,packages.description,packages.id,versions.Version_Number,release_date from autors_packages inner join autors on autors.id = autors_packages.autor_id inner join packages on packages.id = autors_packages.package_id inner JOIN dependencies ON dependencies.child_package_id= packages.id inner join packages_tags on packages.id = packages_tags.package_id INNER JOIN tags ON tags.id = packages_tags.tag_id inner join versions on versions.package_id = autors_packages.package_id WHERE release_date IN(SELECT max(release_date) FROM versions GROUP BY package_id) AND packages.id = ? ORDER BY release_date DESC;";
        $sql = "select autors.name,autors.email, tags.name as tag_name, packages.title,packages.creation_date,packages.description,packages.id,versions.Version_Number,release_date from autors_packages inner join autors on autors.id = autors_packages.autor_id inner join packages on packages.id = autors_packages.package_id inner join packages_tags on packages.id = packages_tags.package_id inner join tags on tags.id = packages.id inner join versions on versions.package_id = autors_packages.package_id WHERE release_date IN(SELECT max(release_date) FROM versions GROUP BY package_id) AND packages.id = ? ORDER BY release_date DESC;";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $details);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo '<div class="bg-slate-900 w-1/2 min-h-28 mb-3 border-sky-800 border grid align-middle">
                <img class="justify-self-center" src="./assets/images/package-x-generic.svg" alt="" width="80">
                <div class="grid grid-cols-12 justify-between w-full">
                    <div class="col-span-11">
                        <form action="package.php" class="" method="get">
                            <input type="hidden" id="details" name="details" value=',$row["id"],'>
                            <input class="text-left text-2xl mb-3 border-0 cursor-pointer" type="submit" id="" name="" value="',$row["title"],'">
                        </form>
                        <p class="text-slate-400">',$row["description"],'</p>
                        <div class= "flex gap-5 text-xs">
                            <p class="text-slate-500">creation date: <span>',$row["creation_date"],'</span></p>
                            <p class="text-slate-500">last updated: <span>',$row["release_date"],'</span></p>
                        </div>
                        <p class="text-slate-500">author: <span>',$row["name"],'</span></p>
                        <p class="text-slate-500">email: <span>',$row["email"],'</span></p>
                        <div class= "flex gap-5 text-xs mb-1">
                            <p class="text-slate-500">tags: <span>',$row["tag_name"],'</span></p>
                            <p class="bg-blue-700 p-1 rounded-full text-white">current version: <span>',$row["Version_Number"],'</span></p>
                        </div>
                    </div>
                </div>
            </div>';
        ?>
    </div>
    <footer class="bg-slate-900 w-full h-48 text-center items-center grid absolute bottom-0">package manager</footer>
</body>
</html>