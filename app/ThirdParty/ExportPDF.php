<?php

namespace App\ThirdParty;

require_once APPPATH . 'ThirdParty/fpdf.php';

class ExportPDF extends \FPDF
{
    private array $theme = [
        'primary' => [255, 90, 31],
        'purple'  => [59, 23, 73],
        'green'   => [22, 199, 132],
        'muted'   => [117, 108, 117],
        'light'   => [247, 240, 251],
        'border'  => [234, 223, 240],
        'danger'  => [180, 35, 35],
    ];

    private function txt($text): string
    {
        $text = (string) $text;
        return iconv('UTF-8', 'windows-1252//TRANSLIT', $text) ?: $text;
    }

    public function initDocument(): void
    {
        $this->SetMargins(14, 14, 14);
        $this->SetAutoPageBreak(true, 18);
        $this->AddPage();
    }

    public function logoAndTitle(string $title): void
    {
        $logoPath = FCPATH . 'assets/img/logo_pdf.png';

        if (is_file($logoPath)) {
            $this->Image($logoPath, 14, 12, 24);
        }

        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(...$this->theme['purple']);
        $this->Cell(0, 10, $this->txt($title), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(...$this->theme['muted']);

        $this->Ln(8);
    }

    public function sectionTitle(string $title): void
    {
        $this->Ln(4);
        $this->SetFillColor(...$this->theme['purple']);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 9, $this->txt($title), 0, 1, 'L', true);
        $this->Ln(3);
    }

    public function infoRow(string $label, string $value): void
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(...$this->theme['purple']);
        $this->SetFillColor(...$this->theme['light']);
        $this->Cell(58, 8, $this->txt($label), 1, 0, 'L', true);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(63, 59, 63);
        $this->Cell(0, 8, $this->txt($value), 1, 1, 'L');
    }

    public function infosClient(?array $user, ?array $client): void
    {
        $this->sectionTitle('Client');

        $this->infoRow('Nom utilisateur', $user['username'] ?? '-');
        $this->infoRow('Email', $user['email'] ?? '-');
        $this->infoRow('Poids actuel', isset($client['poids']) ? $client['poids'] . ' kg' : '-');
        $this->infoRow('Taille', isset($client['taille']) ? $client['taille'] . ' cm' : '-');
        $this->infoRow('Compte Gold', !empty($client['is_gold']) ? 'Oui' : 'Non');
        $this->infoRow('Wallet', isset($client['wallet']) ? number_format((float) $client['wallet'], 0, ',', ' ') . ' Ar' : '-');
    }

    public function infosProgramme(array $data): void
    {
        $this->sectionTitle('Informations du programme');

        $this->infoRow('Régime', $data['regime_name'] ?? '-');
        $this->infoRow('Objectif', $data['objectif_name'] ?? '-');
        $this->infoRow('Durée', ($data['duree_semaine'] ?? '-') . ' semaine(s)');
        $this->infoRow('Objectif en kg', number_format((float) ($data['objectif_kg'] ?? 0), 2, ',', ' ') . ' kg');
        $this->infoRow('Variation / semaine', number_format((float) ($data['variation_totale'] ?? 0), 2, ',', ' ') . ' kg');
        $this->infoRow('Poids initial', number_format((float) ($data['poids_initial'] ?? 0), 2, ',', ' ') . ' kg');
        $this->infoRow('Poids cible', number_format((float) ($data['poids_cible'] ?? 0), 2, ',', ' ') . ' kg');
        $this->infoRow('IMC initial', number_format((float) ($data['imc_initial'] ?? 0), 2, ',', ' '));
    }

    public function infosSports(array $sports): void
    {
        $this->sectionTitle('Sports associés');

        if (empty($sports)) {
            $this->infoRow('Sports', 'Aucun sport associé');
            return;
        }

        foreach ($sports as $sport) {
            $nom = $sport['name'] ?? '-';
            $variation = number_format((float) ($sport['variation_poids_semaine'] ?? 0), 2, ',', ' ') . ' kg / semaine';
            $this->infoRow($nom, $variation);
        }
    }

    public function infosTarification(array $data): void
    {
        $this->sectionTitle('Tarification');

        $this->infoRow('Prix base', number_format((float) ($data['prix_base'] ?? 0), 0, ',', ' ') . ' Ar');
        $this->infoRow('Prix final', number_format((float) ($data['prix_final'] ?? 0), 0, ',', ' ') . ' Ar');

        if (isset($data['solde_actuel'])) {
            $this->infoRow('Solde actuel', number_format((float) $data['solde_actuel'], 0, ',', ' ') . ' Ar');
            $this->infoRow('Solde après achat', number_format((float) ($data['solde_actuel'] - $data['prix_final']), 0, ',', ' ') . ' Ar');
        }
    }

    public function noteFooter(): void
    {
        $this->Ln(8);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(...$this->theme['muted']);
        $this->MultiCell(0, 6, $this->txt('Ce document est un résumé informatif généré par NutriFit.'));
    }
}