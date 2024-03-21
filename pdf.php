<?php
require('fpdf/fpdf.php');

// Fonction pour générer le PDF avec les informations du patient
function generatePDF($patientInfo) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    
    // Ajouter les informations du patient dans le PDF
    foreach ($patientInfo as $key => $value) {
        $pdf->Cell(0,10, $key . ': ' . $value, 0, 1);
    }

    // Nom du fichier PDF
    $filename = 'patient_info_' . time() . '.pdf';

    // Envoi du PDF au navigateur
    $pdf->Output('D', $filename); // 'D' pour télécharger le fichier directement

    return $filename;
}

// Fonction pour récupérer les informations des patients depuis la base de données
function getPatientInfoFromDatabase() {
    // Établir la connexion à la base de données
    $conn = new mysqli("localhost:8889", "root", "root", "lpfs");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Requête pour récupérer les informations des patients
    $sql = "SELECT num_secu, nom_naissance, prenom, date_naissance, telephone FROM patients";

    // Exécution de la requête
    $result = $conn->query($sql);

    $patientInfo = array();

    // Vérifier si des données ont été trouvées
    if ($result->num_rows > 0) {
        // Récupérer les données des patients
        while($row = $result->fetch_assoc()) {
            $patientInfo[] = $row;
        }
    } else {
        echo "Aucun résultat trouvé.";
    }

    // Fermer la connexion à la base de données
    $conn->close();

    return $patientInfo;
}

// Récupérer les informations des patients depuis la base de données
$patientInfoFromDB = getPatientInfoFromDatabase();

foreach ($patientInfoFromDB as $patient) {
    // Générer le PDF pour chaque patient
    generatePDF($patient);
}

?>
