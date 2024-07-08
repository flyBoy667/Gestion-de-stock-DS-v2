<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Connexion à la base de données
include('includes/db_connexion.php');

// Récupération de l'année et du mois sélectionnés
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date("m");

// Crée un nouveau document Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Données Mensuelles');

// Ajoute les en-têtes
$sheet->setCellValue('A1', 'Type');
$sheet->setCellValue('B1', 'Quantité');
$sheet->setCellValue('C1', 'Montant (CFA)');

// Requête pour les ventes
$query = "SELECT SUM(Detail_qte) AS qvente FROM detail WHERE type = 1 AND YEAR(date_commande) = :year AND MONTH(date_commande) = :month";
$statement = $connect->prepare($query);
$statement->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result = $statement->fetch(PDO::FETCH_OBJ);
$qventue = $result->qvente;

// Requête pour le montant des ventes
$query2 = "SELECT SUM(montant_paye) AS mt FROM transaction WHERE type = 1 AND YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month";
$statement2 = $connect->prepare($query2);
$statement2->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result2 = $statement2->fetch(PDO::FETCH_OBJ);
$sum = $result2->mt;

// Requête pour les achats
$query_achat = "SELECT SUM(Detail_qte) AS qachat FROM detail WHERE type = 2 AND YEAR(date_commande) = :year AND MONTH(date_commande) = :month";
$statement_achat = $connect->prepare($query_achat);
$statement_achat->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_achat = $statement_achat->fetch(PDO::FETCH_OBJ);
$qacheter = $result_achat->qachat;

// Requête pour le montant des achats
$query_achat2 = "SELECT SUM(montant_paye) AS mt_achat FROM transaction WHERE type = 2 AND YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month";
$statement_achat2 = $connect->prepare($query_achat2);
$statement_achat2->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_achat2 = $statement_achat2->fetch(PDO::FETCH_OBJ);
$sum_achat = $result_achat2->mt_achat;

// Requête pour les dépenses
$query_expenses = "SELECT SUM(montant) AS total_expenses FROM depense WHERE YEAR(depense_date) = :year AND MONTH(depense_date) = :month";
$statement_expenses = $connect->prepare($query_expenses);
$statement_expenses->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_expenses = $statement_expenses->fetch(PDO::FETCH_OBJ);
$total_expenses = $result_expenses->total_expenses;

// Remplissage du fichier Excel
$sheet->setCellValue('A2', 'Ventes');
$sheet->setCellValue('B2', $qventue);
$sheet->setCellValue('C2', $sum);

$sheet->setCellValue('A3', 'Achats');
$sheet->setCellValue('B3', $qacheter);
$sheet->setCellValue('C3', $sum_achat);

$sheet->setCellValue('A4', 'Dépenses');
$sheet->setCellValue('B4', '');
$sheet->setCellValue('C4', $total_expenses);

// Enregistre le fichier Excel
$writer = new Xlsx($spreadsheet);
$filename = "Rapport_Mensuel_{$selectedYear}_{$selectedMonth}.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
