<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec Tailwind CSS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="/static/js/pre_admission_result.js" defer></script>
</head>

<body class="bg-gray-200 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
        <p id="success_message" class="hidden text-green-500 font-bold">Enregistrement réussi !</p>
        <p id="error_message" class="hidden text-red-500 font-bold">Échec de l'enregistrement: <?php echo $_GET["error"]; ?></p>
        <a href="../../index.html" class="text-blue-500 underline">Retourner à l'accueil</a>

        <!-- Ajout du bouton pour télécharger le PDF -->
        <a href="/pdf.php" class="block mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Télécharger le PDF
        </a>
    </div>
</body>

</html>
