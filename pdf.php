<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<?php
require('fpdf/fpdf.php');

// Connexion à la base de données
$servername = "localhost:8889";
$username = "root";
$password = "root";
$dbname = "lpfs";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

session_start();

// Récupération du numéro de sécurité sociale à partir de la requête POST
$num_secu = $_SESSION['dernier_secu'];

// Requête SQL pour récupérer les informations du patient et ses hospitalisations
$sql = "SELECT DISTINCT patients.nom_naissance, patients.prenom, patients.date_naissance,
               hospitalisations.date_hospitalisation, hospitalisations.heure_intervention, hospitalisations.type_hospitalisation, hospitalisations.num_secu
        FROM patients
        INNER JOIN hospitalisations ON patients.num_secu = hospitalisations.num_secu
        WHERE patients.num_secu = '$num_secu'";
$result = $conn->query($sql);

// Vérification si des données sont récupérées
if ($result->num_rows > 0) {
    // Création du PDF avec FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Informations du patient et ses hospitalisations', 0, 1, 'C');
    
    // Récupération des données du patient
    $row = $result->fetch_assoc();
    $nom_patient = $row["nom_naissance"];
    $prenom_patient = $row["prenom"];
    $date_naissance_patient = $row["date_naissance"];
    $num_secu = $row["num_secu"];
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informations du patient :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nom : ' . $nom_patient, 0, 1);
    $pdf->Cell(0, 10, 'Prénom : ' . $prenom_patient, 0, 1);
    $pdf->Cell(0, 10, 'Date de naissance : ' . $date_naissance_patient, 0, 1);
    $pdf->Cell(0, 10, 'Numéro de sécurité sociale : ' . $num_secu, 0, 1);
    
    // Affichage des hospitalisations
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Hospitalisations :', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    
    while ($row = $result->fetch_assoc()) {
        $date_hospitalisation = $row["date_hospitalisation"];
        $heure_intervention = $row["heure_intervention"];
        $type_hospitalisation = $row["type_hospitalisation"];
        $pdf->Cell(0, 10, 'Date d\'hospitalisation : ' . $date_hospitalisation . ' Heure d\'intervention : ' . $heure_intervention . ' Type : ' . $type_hospitalisation, 0, 1);
    }

    // Sauvegarder le PDF avec un nom unique
    $filename = 'informations_patient_' . uniqid() . '.pdf';
    $pdf->Output('F', $filename);

    // Redirection vers le fichier PDF généré
    header("Location: $filename");
} else {
    echo "Aucune information trouvée pour ce numéro de sécurité sociale.";
}

$conn->close();
?>
    
</body>
</html>