<?php
require("include/fpdf.php");
require("include/utils/functions.php");

class PDF extends FPDF
{
    public $anneeUniversitaire = "";

    function header()
    {
        $this->Image('resources/itu.png', 20, 4, 20);
        $this->SetFont('times', '', 13);
        $this->SetTextColor(105, 112, 119);
        $this->Cell(115);
        $this->Cell(40, 10, utf8_decode('Année universitaire ' . $this->anneeUniversitaire));

        $this->Ln(15);
        $this->SetFont('times', 'B', 16);
        $this->SetTextColor(0, 87, 109);
        $this->Cell(45);
        $this->Cell(80, 10, "RELEVE DE NOTES ET RESULTATS");
    }

    function footer()
    {
        $this->SetY(-20);
        $this->SetFont('times', '', 13);
        $this->Cell(80);
        $this->Cell(0, 0, utf8_decode("Fait à Antananarivo, le ") . date("d/m/Y"), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(80);
        $this->Cell(0, 0, utf8_decode("Le Recteur de l'IT University"), 0, 0, 'C');
    }

    function infosEtudiant($etudiant)
    {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);

        $posLabel = 18;
        $posValeur = 55;
        $interligne = 7;
        $y = 40;

        $this->SetXY($posLabel, $y);
        $this->Cell(30, 8, "Nom:");
        $this->SetXY($posValeur, $y);
        $this->Cell(60, 8, utf8_decode($etudiant["nom"]));

        $y += $interligne;
        $this->SetXY($posLabel, $y);
        $this->Cell(30, 8, utf8_decode("Prénom(s):"));
        $this->SetXY($posValeur, $y);
        $this->Cell(60, 8, utf8_decode($etudiant["prenoms"]));

        $y += $interligne;
        $this->SetXY($posLabel, $y);
        $this->Cell(30, 8, utf8_decode("Né le:"));
        $this->SetXY($posValeur, $y);
        $this->Cell(25, 8, date("d/m/Y", strtotime($etudiant["date_naissance"])));
        $this->Cell(8, 8, utf8_decode("à"));
        $this->Cell(50, 8, utf8_decode($etudiant["lieu_naissance"]));

        $y += $interligne;
        $this->SetXY($posLabel, $y);
        $this->Cell(30, 8, utf8_decode("N° d'inscription:"));
        $this->SetXY($posValeur, $y);
        $this->Cell(60, 8, $etudiant["matricule"]);

        $y += $interligne;
        $this->SetXY($posLabel, $y);
        $this->Cell(30, 8, "Inscrit en:");
        $this->SetXY($posValeur, $y);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(70, 8, utf8_decode($etudiant["niveau"] . "-" . $etudiant["intitule"]));

        $y += 8;
        $this->SetXY($posLabel, $y);
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, 8, "a obtenu les notes suivantes:");

        $this->Ln(15);
    }

    function notesHeader($header)
    {
        $this->SetFont('Arial', 'B', 11);

        $this->SetX(4);

        $this->Cell(22, 8, $header[0], 0, 0, 'C');
        $this->Cell(75, 8, utf8_decode($header[1]), 0, 0, 'C');
        $this->Cell(30, 8, utf8_decode($header[2]), 0, 0, 'C');
        $this->Cell(40, 8, $header[3], 0, 0, 'C');
        $this->Cell(40, 8, utf8_decode($header[4]), 0, 1, 'C');
    }

    function notesContenu($note)
    {
        $this->SetFont('Arial', '', 11);

        $this->SetX(4);

        $this->Cell(22, 7, $note["ue"], 0, 0, 'C');
        $this->Cell(75, 7, utf8_decode($note["intitule"]), 0, 0, 'R');
        $this->Cell(30, 7, $note["credit"], 0, 0, 'C');
        $this->Cell(40, 7, number_format($note["note"], 2, '.', ''), 0, 0, 'C');
        $this->Cell(40, 7, getResultat($note["note"]), 0, 1, 'C');
    }

    function notesMoyenne($numSemestre, $credits, $moyenne)
    {
        $this->SetFont('Arial', 'B', 11);

        $this->SetX(42);

        $this->Cell(45, 8, "SEMESTRE " . $numSemestre, 0, 0, 'C');
        $this->Cell(58, 8, $credits, 0, 0, 'C');
        $this->Cell(13, 8, number_format($moyenne, 2, '.', ''), 0, 0, 'C');
        $this->Cell(66, 8, getResultat($moyenne), 0, 0, 'C');
    }

    function blocResultat($credits, $moyenne, $mention, $decision, $session)
    {
        $this->SetXY(6, 232);

        $this->SetFont('Arial', 'B', 11);
        $this->Cell(39, 7, utf8_decode("Résultat général:"));

        $this->SetFont('Arial', '', 11);
        $this->Cell(40, 7, utf8_decode("Crédits:"));
        $this->Cell(20, 7, $credits, 0, 1);

        $this->Cell(35, 7, "");
        $this->Cell(40, 7, utf8_decode("Moyenne générale:"));
        $this->Cell(20, 7, number_format($moyenne, 2, '.', ''), 0, 1);

        $this->Cell(35, 7, "");
        $this->Cell(40, 7, "Mention:");
        $this->Cell(40, 7, utf8_decode($mention), 0, 1);

        $this->Cell(35, 7, "");
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(40, 7, utf8_decode($decision), 0, 1);

        $this->SetFont('Arial', '', 12);
        $this->Cell(35, 7, "");
        $this->Cell(40, 7, "Session:");
        $this->Cell(30, 7, $session, 0, 1);
    }

    function interligne($h)
    {
        $this->Ln($h);
    }
}
