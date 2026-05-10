<?php
ini_set('display_errors', 1);
require("connex.php");

function getParcours(){
    $sql = "SELECT niveau, intitule FROM parcours";
    $sth = connectDB()->prepare($sql);
    $sth->execute();
    $parcours = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $parcours;
}

function getInfosInscription($matricule)
{
    $sql = "SELECT 
                inscriptions.id,
                inscriptions.matricule,
                inscriptions.annee_universitaire,
                etudiants.nom,
                etudiants.prenoms,
                etudiants.date_naissance,
                etudiants.lieu_naissance,
                parcours.niveau,
                parcours.intitule
            FROM inscriptions
            JOIN etudiants ON inscriptions.etudiant_id = etudiants.id
            JOIN parcours ON inscriptions.parcours_id = parcours.id
            WHERE inscriptions.matricule = :matricule";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "matricule" => $matricule
    ]);
    $infos = $sth->fetch(PDO::FETCH_ASSOC);

    return $infos;
}

function getNotesSemestre($matricule, $parcoursIntitule, $valeurSemestre)
{
    $sql = "SELECT 
                cours.ue,
                cours.intitule,
                cours.credit,
                notes.note,
                semestres.valeur
            FROM notes
            JOIN inscriptions ON notes.inscription_id = inscriptions.id
            JOIN parcours ON inscriptions.parcours_id = parcours.id
            JOIN cours ON notes.cours_id = cours.id
            JOIN semestres ON cours.semestre_id = semestres.id
            WHERE inscriptions.matricule = :matricule
            AND parcours.intitule = :parcoursIntitule
            AND semestres.valeur = :valeurSemestre
            ORDER BY cours.ue ASC";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "matricule" => $matricule,
        "parcoursIntitule" => $parcoursIntitule,
        "valeurSemestre" => $valeurSemestre
    ]);
    $notes = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $notes;
}

function getTotalCreditsSemestre($parcoursIntitule, $valeurSemestre)
{
    $sql = "SELECT SUM(cours.credit) AS total_credits
            FROM cours
            JOIN semestres ON cours.semestre_id = semestres.id
            JOIN parcours ON semestres.parcours_id = parcours.id
            WHERE parcours.intitule = :parcoursIntitule
            AND semestres.valeur = :valeurSemestre";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "parcoursIntitule" => $parcoursIntitule,
        "valeurSemestre" => $valeurSemestre
    ]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    return $result["total_credits"];
}

function getMoyenneSemestre($matricule, $parcoursIntitule, $valeurSemestre)
{
    $sql = "SELECT 
                SUM(notes.note * cours.credit) / SUM(cours.credit) AS moyenne
            FROM notes
            JOIN inscriptions ON notes.inscription_id = inscriptions.id
            JOIN parcours ON inscriptions.parcours_id = parcours.id
            JOIN cours ON notes.cours_id = cours.id
            JOIN semestres ON cours.semestre_id = semestres.id
            WHERE inscriptions.matricule = :matricule
            AND parcours.intitule = :parcoursIntitule
            AND semestres.valeur = :valeurSemestre";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "matricule" => $matricule,
        "parcoursIntitule" => $parcoursIntitule,
        "valeurSemestre" => $valeurSemestre
    ]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    return $result["moyenne"];
}

function getTotalCredits($matricule, $parcoursIntitule)
{
    $sql = "SELECT SUM(cours.credit) AS total_credits
            FROM notes
            JOIN inscriptions ON notes.inscription_id = inscriptions.id
            JOIN parcours ON inscriptions.parcours_id = parcours.id
            JOIN cours ON notes.cours_id = cours.id
            WHERE inscriptions.matricule = :matricule
            AND parcours.intitule = :parcoursIntitule";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "matricule" => $matricule,
        "parcoursIntitule" => $parcoursIntitule
    ]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    return $result["total_credits"];
}

function getMoyenneGenerale($matricule, $parcoursIntitule)
{
    $sql = "SELECT 
                SUM(notes.note * cours.credit) / SUM(cours.credit) AS moyenne
            FROM notes
            JOIN inscriptions ON notes.inscription_id = inscriptions.id
            JOIN parcours ON inscriptions.parcours_id = parcours.id
            JOIN cours ON notes.cours_id = cours.id
            WHERE inscriptions.matricule = :matricule
            AND parcours.intitule = :parcoursIntitule";

    $sth = connectDB()->prepare($sql);
    $sth->execute([
        "matricule" => $matricule,
        "parcoursIntitule" => $parcoursIntitule
    ]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    return $result["moyenne"];
}

function getResultat($note)
{
    if ($note < 10) {
        return "";
    }

    if ($note < 12) {
        return "P";
    }

    if ($note < 14) {
        return "AB";
    }

    if ($note < 16) {
        return "B";
    }

    return "TB";
}

function getMention($moyenne)
{
    if ($moyenne < 10) {
        return "Ajourné";
    }

    if ($moyenne < 12) {
        return "Passable";
    }

    if ($moyenne < 14) {
        return "Assez bien";
    }

    if ($moyenne < 16) {
        return "Bien";
    }

    return "Très bien";
}

function getDecisionFinale($moyenne)
{
    if ($moyenne >= 10) {
        return "ADMIS";
    }

    return "AJOURNE";
}
