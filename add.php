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
    <div class="w-full grid justify-center mb-10">
        <form id="addform" action="data.php" method="post" class="grid gap-1 w-2/12">
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
            <input type="submit" class="bg-blue-700 p-1 mt-2 cursor-pointer rounded-md font-bold">
        </form>
    </div>
    <footer class="bg-slate-900 w-full h-48 text-center items-center hidden sm:grid ">package manager</footer>
</body>
</html>