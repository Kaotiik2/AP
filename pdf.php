<?php
require('FPDF/fpdf.php');

// Connexion à la base de données
$servername = "localhost:3306";
$username = "root";
$password = "Sio2021";
$dbname = "LPFS";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

session_start();

// Récupération du numéro de sécurité sociale à partir de la requête POST
$num_secu = $_SESSION['dernier_secu'];

// Requête SQL pour récupérer les informations du patient
$sql_patient = "SELECT nom_naissance, prenom, date_naissance, num_secu
                FROM patients
                WHERE num_secu = '$num_secu'";
$result_patient = $conn->query($sql_patient);

// Requête SQL pour récupérer les hospitalisations du patient avec les informations du médecin et du type d'hospitalisation
$sql_hospitalisations = "SELECT h.date_hospitalisation, h.heure_intervention, h.medecin_id, h.type_hospitalisation, m.nom AS nom_medecin, m.prenom AS prenom_medecin, th.type AS type_hospitalisation_nom
                         FROM hospitalisations h
                         INNER JOIN medecins m ON h.medecin_id = m.id_medecin
                         INNER JOIN type_hospitalisation th ON h.type_hospitalisation = th.id
                         WHERE h.num_secu = '$num_secu'";
$result_hospitalisations = $conn->query($sql_hospitalisations);

// Vérification si des données sont récupérées
if ($result_patient->num_rows > 0 && $result_hospitalisations->num_rows > 0) {
    // Création du PDF avec FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Spécification de la police Unicode
    $pdf->SetFont('Arial', '', 12);

    // Ajout de l'image en haut et au centre
    $pdf->Image('static/images/LPFS_logo2.png', 55, 10, 100); // Spécifiez le chemin de l'image et les coordonnées x, y et la largeur
    $pdf->Ln(80); // Déplacer vers le bas pour laisser de l'espace pour les informations

    // CSS pour le PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Informations du patient et ses hospitalisations', 0, 1, 'C');
    $pdf->Ln(10);

    // Récupération des données du patient
    $row_patient = $result_patient->fetch_assoc();
    $nom_patient = $row_patient["nom_naissance"];
    $prenom_patient = $row_patient["prenom"];
    $date_naissance_patient = $row_patient["date_naissance"];
    $num_secu = $row_patient["num_secu"];

    // Informations du patient en gras
    $pdf->SetFont('Arial', 'B', 12); // Définir la police en gras
    $pdf->Cell(0, 10, utf8_decode('Informations du patient :'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode('Nom : ') . $nom_patient, 0, 1);
    $pdf->Cell(0, 10, utf8_decode('Prénom : ') . $prenom_patient, 0, 1);
    $pdf->Cell(0, 10, utf8_decode('Date de naissance : ') . $date_naissance_patient, 0, 1);
    $pdf->Cell(0, 10, utf8_decode('Numéro de sécurité sociale : ') . $num_secu, 0, 1);
    $pdf->Ln(10);
    

    // Centrage du tableau des hospitalisations
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('Hospitalisations : '), 0, 1, 'C');
    $pdf->Ln(5); // Espace supplémentaire

// Tableau pour les hospitalisations
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(35, 10, utf8_decode('Date'), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode('Heure'), 1, 0, 'C');
    $pdf->Cell(50, 10, utf8_decode('Médecin'), 1, 0, 'C');
    $pdf->Cell(50, 10, utf8_decode('Type Hospitalisation'), 1, 1, 'C');
    $pdf->SetFont('Arial', '', 12);

    while ($row_hospitalisation = $result_hospitalisations->fetch_assoc()) {
        $date_hospitalisation = $row_hospitalisation["date_hospitalisation"];
        $heure_intervention = $row_hospitalisation["heure_intervention"];
        $nom_medecin = $row_hospitalisation["nom_medecin"];
        $prenom_medecin = $row_hospitalisation["prenom_medecin"];
        $type_hospitalisation_nom = $row_hospitalisation["type_hospitalisation_nom"];

        $pdf->Cell(35, 10, utf8_decode($date_hospitalisation), 1, 0, 'C'); // Utilisez utf8_decode pour convertir les caractères spéciaux
        $pdf->Cell(30, 10, utf8_decode($heure_intervention), 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode($nom_medecin . ' ' . $prenom_medecin), 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode($type_hospitalisation_nom), 1, 1, 'C');
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
