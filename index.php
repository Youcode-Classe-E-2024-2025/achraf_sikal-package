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
<body>
    <nav>
        <h1>package manager</h1>
    </nav>
    <button class="bg-blue-700 p-1 rounded-sm font-bold text-white hidden" onclick="document.getElementById('addform').classList.toggle('hidden'),this.classList.add('hidden'),this.nextElementSibling.classList.toggle('hidden')" >close</button>
    <button class="bg-blue-700 p-1 rounded-sm font-bold text-white" onclick="document.getElementById('addform').classList.toggle('hidden'),this.classList.add('hidden'),this.previousElementSibling.classList.toggle('hidden')" >add package</button>
    <form id="addform" action="" method="post" class="grid gap-1 hidden w-2/12">
        <label for="package">package: </label>
        <input type="text" namespace="package" required>
        <label for="descreption">descreption: </label>
        <input type="text" namespace="descreption" required>
        <label for="version">version: </label>
        <input type="text" namespace="version" required>
        <label for="author">your name: </label>
        <input type="text" namespace="author" required>
        <label for="email">your email: </label>
        <input type="email" namespace="email" required>
        <label for="tag">tag: </label>
        <input type="text" namespace="tag" required>
        <label for="dependancie">dependancie: </label>
        <input type="text" namespace="dependancie" required>
        <input type="submit">
    </form>
    <div id="php" class="mt-6 w-10/12" style= "bg-red-600">
        <?php
        $connection = new mysqli("localhost","root","","package_manager");
        $stmt = $connection->prepare("select * from autors_packages inner join packages on packages.id = autors_packages.package_id inner join autors on autors.id = autors_packages.autor_id");
        $stmt->execute();
        $result = $stmt->get_result();
        echo '<table style="width:100%">';
        while($row = $result->fetch_assoc()){
            echo "<tr><td>",$row["title"],"</td><td>",$row["description"],"</td><td>",$row["name"]."</td></tr>";
        };
        echo '</table>';
        ?>
    </div>
    
    <footer>footer</footer>
</body>
</html>