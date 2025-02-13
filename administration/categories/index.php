<?php $page_courante = "categories"; ?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projets - Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <?php require_once('../header-admin.php'); //récupération du header ?>

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Nos Projets</h1>

            <!-- Tableau des projets -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-6 py-3 border">Icône</th>
                            <th class="px-6 py-3 border">Nom</th>
                            <th class="px-6 py-3 border">Description</th>
                            <th class="px-6 py-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $elements = [
                            ["nom" => "Projet Alpha", "description" => "Un projet innovant", "icon" => "fa-folder"],
                            ["nom" => "Collaboration Beta", "description" => "Travail en équipe", "icon" => "fa-users"],
                            ["nom" => "Catégorie Gamma", "description" => "Classification", "icon" => "fa-tag"],
                            ["nom" => "Message Delta", "description" => "Communication", "icon" => "fa-comment"],
                        ];
                        foreach ($elements as $element) {
                            echo "<tr class='text-center border-b'>";
                            echo "<td class='px-6 py-3 text-xl'><i class='fas {$element["icon"]} text-gray-700'></i></td>";
                            echo "<td class='px-6 py-3'>{$element["nom"]}</td>";
                            echo "<td class='px-6 py-3'>{$element["description"]}</td>";
                            echo "<td class='px-6 py-3'>
                                    <button class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'><i class='fas fa-edit'></i></button>
                                    <button class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700'><i class='fas fa-trash'></i></button>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php require_once('../footer-admin.php'); //récupération du header ?>

</body>
</html>
