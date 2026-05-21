<?php
// index.php — Routeur central
session_start();
header('Content-Type: text/html; charset=utf-8');

$page = $_GET['page'] ?? 'home';

// Protection session pour la page 'cours'
if ($page === 'cours') {
    if (!isset($_SESSION['paiement_ok']) || $_SESSION['paiement_ok'] !== true) {
        header('Location: index.php');
        exit();
    }
}

switch ($page) {
    case 'formations':
        require __DIR__ . '/controllers/FormationController.php';
        break;
    case 'inscription':
        require __DIR__ . '/controllers/InscriptionController.php';
        break;
    case 'paiement':
        require __DIR__ . '/controllers/PaiementController.php';
        break;
    case 'cours':
        require __DIR__ . '/controllers/CoursController.php';
        break;
    case 'succes':
        require __DIR__ . '/views/succes.php';
        break;
    default:
        require __DIR__ . '/controllers/HomeController.php';
}

?>
