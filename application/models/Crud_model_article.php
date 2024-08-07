<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Crud_model_article extends CI_Model
{
  // 
  function __construct()
  {

    parent::__construct();
    date_default_timezone_set('Africa/Lagos');
    $this->load->database('default');
    $this->load->library('session');
    // $this->load->helper('app_gui_helper');
    $this->load->helper('cookie');
    $this->load->helper('url');
    // $this->session->set_userdata('language_abbr', "en"); 
  }

  public function notificationAjout($nom_table, $message)
  {
    $this->db->query("INSERT into notification value('','" . php_uname('n') . "'," . $this->session->userdata('id_profil') . ",'" . $nom_table . "','" . $message . "',now(),now())");

    $this->db->close();
  }

  public function getIdentifiantUtilisateur($id_profil)
  {
    $query = $this->db->query("SELECT * from profil where id_profil=" . $id_profil . "")->row();
    if (count($query) > 0) {
      # code...
      return $query->identifiant;
    }

    $this->db->close();
  }

  public function verifiDateInitialClient()
  {
    $id_client = $_POST["id_client"];
    $date_initial = $_POST["date_initial"];

    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();

    if (count($query) > 0) {
      # code...
      if ($date_initial < date("Y-m-d", strtotime($query->date_init))) {
        # code...
        return "La date de début doit etre supérieure ou égale à la date dinitialisation du client";
      } else {
        return 'ok';
      }
    } else {
      return "Erreur contactez l'administrateur";
    }
  }

  public function getDateInitialClient()
  {
    $id_client = $_POST["id_client"];

    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();

    if (count($query) > 0) {
      # code...
      return $query->date_init;
    } else {
    }
  }

  public function getSoldeInitialClient()
  {
    $id_client = $_POST["id_client"];

    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();

    if (count($query) > 0) {
      # code...
      return $query->montant_init;
    } else {
      return 0;
    }
  }


  public function getClient($id_client)
  {
    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =" . $id_client . "")->row();
    if (count($query) > 0) {
      # code...
      return $query->nom;
    }
  }

  public function getAdresseClient($id_client)
  {
    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =" . $id_client . "")->row();
    if (count($query) > 0) {
      # code...
      return $query->adresse;
    }
  }

  public function getVilleClient($id_client)
  {
    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =" . $id_client . "")->row();
    if (count($query) > 0) {
      # code...
      return $query->ville;
    }
  }

  public function getTelephoneClient($id_client)
  {
    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =" . $id_client . "")->row();
    if (count($query) > 0) {
      # code...
      return $query->telephone;
    }
  }

  public function soldeCaisseClient2()
  {
    echo $this->repportNouveau3() - $this->selectAllTotalAccuseReglementPourBalanceClient() + $this->totalFacturePourBalanceClient();
  }

  public function repportNouveau3()
  {

    $id_fournisseur = $_POST["id_fournisseur"];
    $id_client = $_POST["id_fournisseur"];


    $date_fin = date("Y-m-d", strtotime($_POST["date_debut"] . '- 1 day'));
    $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();
    $soldeInitial = 0;
    if (count($getDateInitialClient) > 0) {
      # code...
      $soldeInitial = $getDateInitialClient->montant_init;
      $date_debut = $getDateInitialClient->date_init;
    } else {
      $date_debut = "";
    }
    // echo $date_fin;
    return $soldeInitial - $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur, $date_debut, $date_fin) + $this->totalFacturePourRepport($id_fournisseur, $date_debut, $date_fin);
  }


  public function selectAllTotalAccuseReglementPourRepport($id_fournisseur, $date_debut, $date_fin)
  {

    $montant = 0;

    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT  * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' order by date_reg asc')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg>="' . $date_debut . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE date_reg<="' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE date_reg between "' . $date_debut . '" and "' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg between "' . $date_debut . '" and "' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg<="' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg>="' . $date_debut . '" order by date_reg asc')->result_array();
    }
    $compteur = 0;

    foreach ($query1 as $tab) {
      $montant = $montant + $tab['montant'];
    }

    return $montant;
  }

  public function totalFacturePourRepport($id_fournisseur, $date_debut, $date_fin)
  {
    $date = date('Y-m-d');

    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT  * FROM facture_article WHERE id_fournisseur=' . $id_fournisseur . ' order by date_fact asc')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="' . $date_debut . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE date_fact<="' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE date_fact between "' . $date_debut . '" and "' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur =' . $id_fournisseur . ' and date_fact between "' . $date_debut . '" and "' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur=' . $id_fournisseur . ' and date_fact<="' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur =' . $id_fournisseur . ' and date_fact>="' . $date_debut . '" order by date_fact asc')->result_array();
    }
    // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
    $compteur = 0;
    $total = 0;
    $montant = 0;
    foreach ($query1 as $row) {
      # code...

      # code...


      $montant = $row['montant'] + $montant;
      $compteur++;
    }

    return $montant;
  }


  public function selectAllTotalAccuseReglementPourBalanceClient()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];

    $montant = 0;




    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT  * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' order by date_reg asc')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg>="' . $date_debut . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE date_reg<="' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE date_reg between "' . $date_debut . '" and "' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg between "' . $date_debut . '" and "' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg<="' . $date_fin . '" order by date_reg asc')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE id_fournisseur = ' . $id_fournisseur . ' and date_reg>="' . $date_debut . '" order by date_reg asc')->result_array();
    }
    $compteur = 0;

    foreach ($query1 as $tab) {
      $montant = $montant + $tab['montant'];
    }


    return $montant;
  }


  public function totalFacturePourBalanceClient()
  {
    $date = date('Y-m-d');
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT  * FROM facture_article WHERE id_fournisseur=' . $id_fournisseur . ' order by date_fact asc')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="' . $date_debut . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE date_fact<="' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE date_fact between "' . $date_debut . '" and "' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur =' . $id_fournisseur . ' and date_fact between "' . $date_debut . '" and "' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur=' . $id_fournisseur . ' and date_fact<="' . $date_fin . '" order by date_fact asc')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE id_fournisseur =' . $id_fournisseur . ' and date_fact>="' . $date_debut . '" order by date_fact asc')->result_array();
    }
    // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
    $compteur = 0;
    $total = 0;
    $montant = 0;
    foreach ($query1 as $row) {
      # code...


      $montant = $row['montant'] + $montant;
      $compteur++;
      // }
    }

    return $montant;
  }

  public function repportNouveau($id_client)
  {
    if (isset($id_client) || !empty($id_client)) {
      # code...
      $id_fournisseur = $id_client;
    } else {
      $id_fournisseur = $_POST["id_fournisseur"];
    }
    $date_fin = date("Y-m-d", strtotime($_POST["date_debut"] . '- 1 day'));
    $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();
    $soldeInitial = 0;
    if (count($getDateInitialClient) > 0) {
      # code...
      $soldeInitial = $getDateInitialClient->montant_init;
      $date_debut = $getDateInitialClient->date_init;
    } else {
      $date_debut = "";
    }
    // echo $date_fin;
    return $soldeInitial - $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur, $date_debut, $date_fin) + $this->totalFacturePourRepport($id_fournisseur, $date_debut, $date_fin);
  }

  public function repportNouveauCredit($id_client)
  {
    if (isset($id_client) || !empty($id_client)) {
      # code...
      $id_fournisseur = $id_client;
    } else {
      $id_fournisseur = $_POST["id_fournisseur"];
    }


    $date_fin = date("Y-m-d", strtotime($_POST["date_debut"] . '- 1 day'));
    $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();
    $soldeInitial = 0;
    if (count($getDateInitialClient) > 0) {
      # code...
      $soldeInitial = $getDateInitialClient->montant_init;
      $date_debut = $getDateInitialClient->date_init;
    } else {
      $date_debut = "";
    }
    // echo $date_fin;
    return $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur, $date_debut, $date_fin);
  }

  public function repportNouveauDebit($id_client)
  {
    if (isset($id_client) || !empty($id_client)) {
      # code...
      $id_fournisseur = $id_client;
    } else {
      $id_fournisseur = $_POST["id_fournisseur"];
    }


    $date_fin = date("Y-m-d", strtotime($_POST["date_debut"] . '- 1 day'));
    $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id_client . "")->row();
    $soldeInitial = 0;
    if (count($getDateInitialClient) > 0) {
      # code...
      $soldeInitial = $getDateInitialClient->montant_init;
      $date_debut = $getDateInitialClient->date_init;
    } else {
      $date_debut = "";
    }
    // echo $date_fin;
    return $this->totalFacturePourRepport($id_fournisseur, $date_debut, $date_fin);
  }

  public function getCreditPourBalanceImpCLient()
  {
    return $this->selectAllTotalAccuseReglementPourBalanceClient();
  }

  public function getDebitPourBalanceImpCLient()
  {
    return $this->totalFacturePourBalanceClient();
  }

  public function getSoldeBalanceImprimableClient()
  {
    $id_client = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));

    $i = 0;



    $totalAccuseReglement = 0;
    $totalFactureCLient = 0;

    $totalSolde = 0;
    $totalDebit = 0;
    $totalCredit = 0;
    $solde = 0;

    $debit3 = 0;
    $credit3 = 0;
    $RN = $this->repportNouveau($id_client);
    $compteur = 0;


    while (date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')) <= $_POST["date_fin"]) {
      # code...
      $date_debut = strval(date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')));


      $debit1 = 0;

      $debit = 0;
      $credit = 0;



      // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
      $montant = 0;
      $total = 0;

      $getAccuseReglement = $this->db->query('SELECT * from reglement_article where id_fournisseur = ' . $id_client . ' and date_reg ="' . $date_debut . '"')->result_array();
      if (count($getAccuseReglement) > 0) {
        # code...
        foreach ($getAccuseReglement as $reglement) {
          # code...
          $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
          $credit1 = $reglement['montant'];
          $credit3 = $credit3 + $credit1;


          $RN = $RN - $credit1;

          $solde = $RN;

          $totalSolde = $totalSolde + $solde;
        }
      }

      $getFactureClient = $this->db->query("SELECT * from facture_article where id_fournisseur=" . $id_client . " and date_fact='" . $date_debut . "' group by numero")->result_array();
      if (count($getFactureClient) > 0) {
        # code...
        foreach ($getFactureClient as $factureClient) {
          # code...
          // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);

          $totalFactureCLient = $factureClient['montant'] + $totalFactureCLient;

          $debit = $factureClient['montant'];

          $debit3 = $debit + $debit3;


          $RN = $RN + $debit;

          $solde = $RN;

          $totalSolde = $totalSolde + $solde;
        }
      }



      $totalDebit = $debit3;
      $totalCredit = $credit3;
      // $totalSolde = $totalSolde + $solde;
      $i++;
      $compteur++;
    }
    return $solde;
  }

  public function getBalanceImprimableClient()
  {
    $id_client = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));

    $i = 0;
    $totalAccuseReglement = 0;
    $totalFactureCLient = 0;

    $totalSolde = 0;

    $totalCredit = 0;
    $solde = 0;

    $debit3 = 0;
    $credit3 = 0;

    $RN = $this->repportNouveau($id_client);
    $compteur = 0;

    $compteur1 = 0;

    while (date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')) <= $_POST["date_fin"]) {
      # code...
      $date_debut = strval(date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')));



      // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
      $montant = 0;
      $total = 0;
      // foreach ($getAllNumFactureClient as $num_facture) {
      $getAccuseReglement = $this->db->query('SELECT * from reglement_article where id_fournisseur = ' . $id_client . ' and date_reg ="' . $date_debut . '"')->result_array();
      if (count($getAccuseReglement) > 0) {
        # code...
        foreach ($getAccuseReglement as $reglement) {
          # code...
          $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
          $credit1 = $reglement['montant'];
          $credit3 = $credit3 + $credit1;


          $RN = $RN - $credit1;

          $solde = $RN;

          echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>" . $date_debut . "</td>
        <td style='border: 2px solid black;'>" . $reglement['numero'] . "</td>
        <td style='border: 2px solid black;'>" . $reglement['libelle'] . "</td>
        <td style='border: 2px solid black;'>" . number_format($credit1, 0, ',', ' ') . "</td>
        <td style='border: 2px solid black;'>0</td>
        
        <td style='border: 2px solid black;'>" . number_format($solde, 0, ',', ' ') . "</td>
    </tr>";

          $totalSolde = $totalSolde + $solde;
          $compteur1++;
        }
      }

      $getFactureClient = $this->db->query("SELECT * from facture_article where id_fournisseur =" . $id_client . " and date_fact='" . $date_debut . "' group by numero")->result_array();
      if (count($getFactureClient) > 0) {
        # code...
        foreach ($getFactureClient as $factureClient) {
          $totalFactureCLient = $factureClient['montant'] + $totalFactureCLient;
          $debit = $factureClient['montant'];
          $debit3 = $debit + $debit3;


          $RN = $RN + $debit;

          $solde = $RN;

          echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>" . $date_debut . "</td>
        <td style='border: 2px solid black;'>" . $factureClient['numero'] . "</td>
        <td style='border: 2px solid black;'>" . $factureClient['libelle'] . "</td>

        <td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>" . number_format($debit, 0, ',', ' ') . "</td>

        <td style='border: 2px solid black;'>" . number_format($solde, 0, ',', ' ') . "</td>
        </tr>";

          $compteur1++;
        }
      }

      $totalDebit = $debit3;
      $totalCredit = $credit3;

      // $totalSolde = $totalSolde + $solde;
      $i++;
      $compteur++;
    }

    echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($compteur1, 0, ',', ' ') . "</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($totalCredit, 0, ',', ' ') . "</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($totalDebit, 0, ',', ' ') . "</td>
		
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($this->getSoldeBalanceImprimableClient(), 0, ',', ' ') . "</td>
    </tr>";

    
    //return the solde after calcul *SKT*
    return number_format($this->getSoldeBalanceImprimableClient(), 0, ',', ' ');
  }

  public function getBalanceImprimablePartnerForOdoo($id_fournisseur, $date_debut, $date_fin)
  {
    $id_client = $id_fournisseur;
    //$date_debut = $_POST["date_debut"];
    //$date_fin = $_POST["date_fin"];
    // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));

    $i = 0;
    $totalAccuseReglement = 0;
    $totalFactureCLient = 0;

    $totalSolde = 0;

    $totalCredit = 0;
    $solde = 0;

    $debit3 = 0;
    $credit3 = 0;

    $RN = $this->repportNouveau($id_client);
    $compteur = 0;

    $compteur1 = 0;

    while (date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')) <= $_POST["date_fin"]) {
      # code...
      $date_debut = strval(date("Y-m-d", strtotime($_POST["date_debut"] . '+ ' . $i . ' day')));



      // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
      $montant = 0;
      $total = 0;
      // foreach ($getAllNumFactureClient as $num_facture) {
      $getAccuseReglement = $this->db->query('SELECT * from reglement_article where id_fournisseur = ' . $id_client . ' and date_reg ="' . $date_debut . '"')->result_array();
      if (count($getAccuseReglement) > 0) {
        # code...
        foreach ($getAccuseReglement as $reglement) {
          # code...
          $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
          $credit1 = $reglement['montant'];
          $credit3 = $credit3 + $credit1;


          $RN = $RN - $credit1;

          $solde = $RN;

          echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>" . $date_debut . "</td>
        <td style='border: 2px solid black;'>" . $reglement['numero'] . "</td>
        <td style='border: 2px solid black;'>" . $reglement['libelle'] . "</td>
        <td style='border: 2px solid black;'>" . number_format($credit1, 0, ',', ' ') . "</td>
        <td style='border: 2px solid black;'>0</td>
        
        <td style='border: 2px solid black;'>" . number_format($solde, 0, ',', ' ') . "</td>
    </tr>";

          $totalSolde = $totalSolde + $solde;
          $compteur1++;
        }
      }

      $getFactureClient = $this->db->query("SELECT * from facture_article where id_fournisseur =" . $id_client . " and date_fact='" . $date_debut . "' group by numero")->result_array();
      if (count($getFactureClient) > 0) {
        # code...
        foreach ($getFactureClient as $factureClient) {
          $totalFactureCLient = $factureClient['montant'] + $totalFactureCLient;
          $debit = $factureClient['montant'];
          $debit3 = $debit + $debit3;


          $RN = $RN + $debit;

          $solde = $RN;

          echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>" . $date_debut . "</td>
        <td style='border: 2px solid black;'>" . $factureClient['numero'] . "</td>
        <td style='border: 2px solid black;'>" . $factureClient['libelle'] . "</td>

        <td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>" . number_format($debit, 0, ',', ' ') . "</td>

        <td style='border: 2px solid black;'>" . number_format($solde, 0, ',', ' ') . "</td>
        </tr>";

          $compteur1++;
        }
      }

      $totalDebit = $debit3;
      $totalCredit = $credit3;

      // $totalSolde = $totalSolde + $solde;
      $i++;
      $compteur++;
    }

    echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($compteur1, 0, ',', ' ') . "</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($totalCredit, 0, ',', ' ') . "</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($totalDebit, 0, ',', ' ') . "</td>
		
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>" . number_format($this->getSoldeBalanceImprimableClient(), 0, ',', ' ') . "</td>
    </tr>";

    
    //return the solde after calcul *SKT*
    return number_format($this->getSoldeBalanceImprimableClient(), 0, ',', ' ');
  }


  public function selectAllArticle()
  {
    $query = $this->db->query("SELECT * from article order by article asc")->result_array();

    if (count($query) > 0) {
      # code...
      $compteur = 0;
      foreach ($query as $row) {
        # code...
        $getCategorie = $this->db->query("select * from categorie_article where id_categorie=" . $row['id_categorie'] . "")->row();
        echo "<tr >
                    <td onclick=\"creerDatable();\">" . $compteur . "</td>
                   
                    <td>" . $row['article'] . "</td>
                    <td>" . $getCategorie->categorie . "</td>
                    <td> " . number_format($row['prix_unitaire'], 0, ',', ' ') . "</td>
                    <td> " . $row['code_a_barre'] . "</td>
                    <td> " . $row['fournisseur'] . "</td>
                    <td> " . $row['manufacturier'] . "</td>
                   
                     <td> " . $row['seuil_commande'] . " </td>
                    <td>";

        if ($this->session->userdata('stock_modification') == 'true') {
          echo "
                    <button type='button' onclick='infosLivraison(\"annulé\",\"" . $row['article'] . "\",\"" . $row['prix_unitaire'] . "\",\"" . $row['code_a_barre'] . "\",\"" . $row['fournisseur'] . "\",\"" . $row['manufacturier'] . "\",\"" . $row['seuil_commande'] . "\",\"" . $row['id_article'] . "\",\"" . $row['commentaire'] . "\",\"" . $row['reference'] . "\",\"" . $row['id_type_pneu'] . "\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
        }

        if ($this->session->userdata('stock_suppression') == 'true') {
          echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='article' identifiant='" . $row['id_article'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_article\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
        }
        $compteur++;
      }
    }
    $this->db->close();
  }

  public function addArticle()
  {
    $reference = addslashes($_POST['reference']);
    $numero = $_POST["numero"];
    $article = $_POST["article"];
    $seuil_commande = $_POST["seuilCommande"];
    $fournisseur = $_POST["fournisseur"];
    $manufacturier = $_POST["manufacturier"];
    $codeBarre = $_POST["codeBarre"];
    $categorie = $_POST["categorie"];
    $PU = preg_replace('/\s/', '', $_POST["PU"]);
    $status = $_POST["status"];
    $commentaire = addslashes($_POST["commentaire"]);
    $id_fournisseur = addslashes($_POST["id_fournisseur"]);

    $nom_table = "article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté l'article'  " . $article . ", de prix unitaire " . $PU . " et numéro " . $numero . " le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié l'article'  " . $article . ", de prix unitaire " . $PU . " et de numéro " . $numero . " le " . $date_notif . " à " . $heure;


    if ($status == 'insert') {
      // $requeteNumero = $this->db->query("select * from article where numero ='".$numero."'")->result_array();
      $requeteArticle = $this->db->query("select * from article where article ='" . $article . "'")->result_array();
      if (count($requeteArticle) > 0) {
        # code...
        echo "Un article de même nom existe déjà";
      } else {
        $requete = $this->db->query("INSERT into article value(''," . $categorie . ",'" . $article . "'," . $PU . ",'" . $codeBarre . "','" . $fournisseur . "','" . $manufacturier . "'," . $seuil_commande . ",'" . $commentaire . "','" . $reference . "'," . $id_fournisseur . ")");
        if ($requete == true) {
          # code...
          echo "Création parfaite de l'article";
          $this->notificationAjout($nom_table, addslashes($message));
        } else {
          echo "Erreur d'insertion";
        }
      }
      # code...

    } elseif ($status == 'update') {
      # code...
      $id_BL = $_POST["id_BL"];
      // $requeteNumero = $this->db->query("select * from article where numero ='".$numero."'")->result_array();
      $requeteArticle = $this->db->query("select * from article where article ='" . $article . "'")->result_array();

      if (count($requeteArticle) > 0) {
        # code...

        foreach ($requeteArticle as $tab2) {
          # code...
          if ($id_BL == $tab2["id_article"]) {
            $requete = $this->db->query("UPDATE article set  article='" . $article . "', prix_unitaire=" . $PU . ", code_a_barre = '" . $codeBarre . "', fournisseur='" . $fournisseur . "', manufacturier='" . $manufacturier . "',seuil_commande=" . $seuil_commande . ",id_categorie=" . $categorie . ",commentaire='" . $commentaire . "',reference='" . $reference . "' ,id_type_pneu=" . $id_fournisseur . " where id_article=" . $id_BL . "");
            if ($requete == true) {
              # code...
              echo "Modification parfaite de l'article";
              $this->notificationAjout($nom_table, addslashes($message2));
            } else {
              echo "Erreur d'insertion";
            }
          } else {
            echo "Un article de même nom existe déjà";
          }
        }
      } else {

        $requete = $this->db->query("UPDATE article set article='" . $article . "', prix_unitaire=" . $PU . ", code_a_barre = '" . $codeBarre . "', fournisseur='" . $fournisseur . "', manufacturier='" . $manufacturier . "',seuil_commande=" . $seuil_commande . ",commentaire='" . $commentaire . "',reference='" . $reference . "' ,id_type_pneu=" . $id_fournisseur . " where id_article=" . $id_BL . "");
        if ($requete == true) {
          # code...
          echo "Modification parfaite de l'article";
          $this->notificationAjout($nom_table, addslashes($message2));
        } else {
          echo "Erreur d'insertion";
        }
      }
    } else {
      echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
  }

  public function leSelectClient()
  {
    $query1 = $this->db->query("select * from client")->result_array();
    if (count($query1) > 0) {
      foreach ($query1 as $row) {
        echo "<option value='" . $row["id_client"] . "'>" . $row["telephone"] . "</option>";
      }
    } else {
      echo "<option value=''>aucune</option>";
    }

    $this->db->close();
  }

  public function leSelectCategorie()
  {
    $query1 = $this->db->query("select * from categorie_article")->result_array();
    if (count($query1) > 0) {
      foreach ($query1 as $row) {
        echo "<option value='" . $row["id_categorie"] . "'>" . $row["categorie"] . "</option>";
      }
    } else {
      echo "<option value=''>aucune</option>";
    }

    $this->db->close();
  }



  public function addTypeArticle()
  {
    $categorie = $_POST["categorie"];
    $commentaire = $_POST["commentaire"];

    $status = $_POST["status"];


    $nom_table = "categorie_article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté la catégorie d'article " . $categorie . " le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié la catégorie d'article " . $categorie . " le " . $date_notif . " à " . $heure;


    if ($status == "insert") {
      # code...

      $requete = $this->db->query("SELECT * from categorie_article where categorie ='" . $categorie . "'")->result_array();
      if (count($requete) > 0) {
        # code...
        echo "Erreur cette catégorie existe déjà pour ce type veuiller changer";
      } else {
        $query1 = $this->db->query("INSERT into categorie_article value('','" . $categorie . "','" . $commentaire . "')");
        if ($query1 == true) {
          echo "Insertion parfaite de la catégorie d'article";
          $this->notificationAjout($nom_table, addslashes($message));
        } else {
          echo "Erreur durant l'insertion";
        }
      }
    } elseif ($status == "update") {
      # code...
      $id_client = $_POST["id_client"];
      $requete = $this->db->query("SELECT * from categorie_article where categorie ='" . $categorie . "'")->result_array();
      if (count($requete) > 0) {
        # code...
        foreach ($requete as $row) {
          # code...
          if ($row["id_categorie"] == $id_client) {
            # code...
            $query1 = $this->db->query("UPDATE categorie_article set categorie='" . $categorie . "', commentaire='" . $commentaire . "' where id_categorie=" . $id_client . "");
            if ($query1 == true) {
              echo "Modification parfaite du la catégorie";
              $this->notificationAjout($nom_table, addslashes($message2));
            } else {
              echo "Erreur durant l'insertion";
            }
          } else {
            echo "Erreur cette huile existe déjà pour ce type veuiller changer";
          }
        }
      } else {
        $query1 = $this->db->query("UPDATE categorie_article set categorie='" . $categorie . "', commentaire='" . $commentaire . "' where id_categorie=" . $id_client . "");
        if ($query1 == true) {
          echo "Modification parfaite du la catégorie";
          $this->notificationAjout($nom_table, addslashes($message2));
        } else {
          echo "Erreur durant l'insertion";
        }
      }
    } else {
      echo "Erreur contactez l'administrateur" . $status;
    }
    $this->db->close();
  }

  public function selectAllTypeArticle()
  {
    $query1 = $this->db->get_where('categorie_article')->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...
      echo "<tr >
                    <td onclick=\"creerDatable();\">" . $compteur . "</td>
                    <td>" . $row['categorie'] . "
                    </td>
                    <td>" . $row['commentaire'] . "</td>
                  
                    <td>";
      if ($this->session->userdata('stock_modification') == 'true') {
        echo "
                    <button type='button' onclick=\"infosTypeArticle('" . $row['categorie'] . "','" . $row['commentaire'] . "','" . $row['id_categorie'] . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
      }
      if ($this->session->userdata('stock_suppression') == 'true') {

        echo "  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='categorie_article' identifiant='" . $row['id_categorie'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_categorie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
      }
      $compteur++;
    }

    $this->db->close();
  }

  // le code qui suit est celui des fournisseur d'articles

  public function addFournisseurArticle()
  {
    $commentaire = addslashes($_POST["commentaire"]);
    $nom = $_POST["nom"];
    $telephone = $_POST["telephone"];
    $adresse = $_POST["adresse"];
    $status = $_POST["status"];
    $montant_init = preg_replace('/\s/', '', $_POST["montant_init"]);
    $date_init = $_POST["date_init"];



    $nom_table = "fournisseur_article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté un fournisseur d'article appelé " . $nom . " et de téléphone " . $telephone . " le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié un fournisseur d'article appelé " . $nom . " et de téléphone " . $telephone . " le " . $date_notif . " à " . $heure;

    if ($status == "insert") {
      # code...
      // echo $telephone;
      //   $requete = $this->db->query("SELECT * from fournisseur_article where telephone =".$telephone."")->result_array();
      //   if (count($requete)>0) {
      # code...
      //      echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
      // }else{
      $query1 = $this->db->query("insert into fournisseur_article value('','" . $nom . "','" . $adresse . "'," . $telephone . ",'" . $commentaire . "'," . $montant_init . ",'" . $date_init . "')");
      if ($query1 == true) {
        echo "Insertion parfaite du fournisseur";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur durant l'insertion";
      }
      //   }
    } elseif ($status == "update") {
      # code...
      $id_client = $_POST["id_client"];
      $requete = $this->db->query("SELECT * from fournisseur_article where telephone =" . $telephone . "")->result_array();
      if (count($requete) > 0) {
        # code...
        foreach ($requete as $row) {
          # code...
          if ($row["id_fournisseur"] == $id_client) {
            # code...
            $query1 = $this->db->query("UPDATE fournisseur_article set telephone=" . $telephone . ", adresse='" . $adresse . "', nom='" . $nom . "',commentaire = '" . $commentaire . "', montant_init= " . $montant_init . ",date_init = '" . $date_init . "' where id_fournisseur =" . $id_client . "");
            if ($query1 == true) {
              echo "Modification parfaite du fournisseur";
              $this->notificationAjout($nom_table, addslashes($message2));
            } else {
              echo "Erreur durant l'insertion";
            }
          } else {
            echo "Erreur ce numero de téléphone est déjà utilisé";
          }
        }
      } else {
        $query1 = $this->db->query("UPDATE fournisseur_article set telephone=" . $telephone . ", adresse='" . $adresse . "', nom='" . $nom . "',commentaire = '" . $commentaire . "', montant_init=" . $montant_init . ",date_init = '" . $date_init . "' where id_fournisseur=" . $id_client . "");
        if ($query1 == true) {
          echo "Modification parfaite du fournisseur";
          $this->notificationAjout($nom_table, addslashes($message2));
        } else {
          echo "Erreur durant l'insertion";
        }
      }
    } else {
      echo "Erreur contactez l'administrateur";
    }
    $this->db->close();
  }

  public function selectAllFournisseurArticle()
  {
    $query1 = $this->db->query('SELECT * from fournisseur_article order by nom asc')->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...
      echo "<tr >
                    <td onclick=\"creerDatable();\">" . $compteur . "</td>
                    <td>" . $row['nom'] . "
                    </td>
                    <td>" . $row['adresse'] . "</td>
                    <td> " . $row['telephone'] . "</td>
					<td>" . $row['montant_init'] . "</td>
                    <td> " . $row['date_init'] . "</td>
                    <td>";
      if ($this->session->userdata('article_modification') == 'true') {
        echo "
                    <button type='button' onclick=\"infosClient1('" . $row['id_fournisseur'] . "','" . $row['nom'] . "','" . $row['adresse'] . "','" . $row['telephone'] . "','" . addslashes($row['commentaire']) . "','" . $row['montant_init'] . "','" . $row['date_init'] . "');\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
      }
      if ($this->session->userdata('article_suppression') == 'true') {
        echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_article' identifiant='" . $row['id_fournisseur'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
      }
      $compteur++;
    }

    $this->db->close();
  }

  public function leSelectFournisseurArticle()
  {
    $query = $this->db->query("select * from fournisseur_article Order by nom")->result_array();
    if (count($query) > 0) {
      # code...
      echo "<option value=''></option>";
      foreach ($query as $row) {
        # code...

        echo "<option value='" . $row["id_fournisseur"] . "'>" . $row["nom"] . "</option>";
      }
    } else {
    }

    $this->db->close();
  }

  public function leSelectFournisseurArticle1()
  {
    $query = $this->db->query("select * from fournisseur_article Order by nom")->result_array();
    if (count($query) > 0) {
      # code...

      foreach ($query as $row) {
        # code...

        echo "<option value='" . $row["id_fournisseur"] . "'>" . $row["nom"] . "</option>";
      }
    } else {
    }

    $this->db->close();
  }
  public function  getFournisseurMira()
  {
    $id_fournisseur = $_POST['id_fournisseur'];
    $query = $this->db->query("select * from fournisseur_article where id_fournisseur = " . $id_fournisseur . " ")->result_array();
    if (count($query) > 0) {
      # code...
      foreach ($query as $row) {
        # code...
        echo "<option value='" . $row["id_fournisseur"] . "'>" . $row["nom"] . "</option>";
      }
    } else {
    }


    $this->db->close();
  }


  public function leSelectBL()
  {
    $query = $this->db->query("SELECT bl, SUM(montant) AS prix_bl FROM approvisionnement WHERE bl not in (SELECT libelle from facture_article) GROUP BY bl")->result_array();
    # echo "<option value='0'>numero du bon Livraison</option>";
    if (count($query) > 0) {
      # code...
      foreach ($query as $row) {
        # code...
        echo "<option value='" . $row["bl"] . "'>" . $row["bl"] . ">" . $row["prix_bl"] . "</option>";
      }
    } else {
    }

    $this->db->close();
  }

  public function selectMontFactureBL()
  {

    $id_bl = $_POST["id_bl"];
    $id_fournisseur = $_POST["id_fournisseur"];

    $montant1 = 0;

    $montant2 = 0;

    $getMontant = $this->db->query("SELECT * FROM approvisionnement where bl = '" . $id_bl . "' and id_fournisseur = " . $id_fournisseur . " ORDER BY date_app")->result_array();
    if (count($getMontant) > 0) {
      # code...
      #echo $getMontant->litrage * $getMontant->prix_unitaire;

      foreach ($getMontant as $row) {
        # code...

        $montant1 = $row["qtite"] * $row["montant"];
        $montant2 =  $montant2 + $montant1;
        //  $montant2 =  $montant1;
      }
      echo $montant2;
    }
    $this->db->close();
  }

  public function leSelectBLParFournisseur()
  {
    $id_fournisseur = $_POST["id_fournisseur"];


    $getbl = $this->db->query("SELECT bl, SUM(montant) AS prix_bl FROM approvisionnement WHERE id_fournisseur = " . $id_fournisseur . " and bl not in (SELECT libelle from facture_article) GROUP BY bl")->result_array();

    #$getbl = $this->db->query("SELECT bl, SUM(montant) AS prix_bl FROM approvisionnement GROUP BY bl")->result_array();

    if (count($getbl) > 0) {
      # code...
      foreach ($getbl as $row) {
        # code...
        echo "<option value='" . $row["bl"] . "'>" . $row["bl"] . " </option>";
      }
    }

    $this->db->close();
  }
  public function addFacture()
  {
    $status = $_POST["status"];
    $numero = $_POST["numero"];
    $montant = intval(preg_replace('/\s/', '', $_POST["montant"]));
    $date = $_POST["date"];
    $echeance = $_POST["echeance"];
    //$id_bl = $_POST["id_bl"];
    $id_fournisseur = $_POST["id_fournisseur"];
    ///$cloturer = $_POST["cloturer"];
    $remise = intval(preg_replace('/\s/', '', $_POST["remise"]));

    $nom_table = "facture_article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté une facture article N°" . $numero . ", d'un montant" . $montant . ",  le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié une facture article N°" . $numero . ", d'un montant" . $montant . ",  le " . $date_notif . " à " . $heure;


    if ($status == "insert") {
      # code...
      $verifNumero = $this->db->query("SELECT * FROM facture_article WHERE numero = '" . $numero . "' and id_fournisseur =" . $id_fournisseur . "")->row();
      if (count($verifNumero) > 0) {
        # code...

        if ($verifNumero->id_fournisseur == $id_fournisseur) {
          # code...
          echo "Ce numéro de facture est déjà utilisé par ce fournisseur veuillez changer";
        } else {
          $insertFacture = $this->db->query("INSERT INTO facture_article value(''," . $id_fournisseur . ",'" . $numero . "',CAST('" . $date . "' AS DATE)," . $montant . "," . $remise . ",'" . $numero . "',CAST('" . $echeance . "' AS DATE),0)");
          if ($insertFacture == true) {
            # code...
            echo "Insertion parfaite de la facture";
            $this->notificationAjout($nom_table, addslashes($message));
          } else {
            echo "Erreur d'insertion";
          }
        }
      } else {
        $insertFacture = $this->db->query("INSERT INTO facture_article value(''," . $id_fournisseur . ",'" . $numero . "',CAST('" . $date . "' AS DATE)," . $montant . "," . $remise . ",'" . $numero . "',CAST('" . $echeance . "' AS DATE), 0)");
        if ($insertFacture == true) {
          # code...
          echo "Insertion parfaite de la facture";
          $this->notificationAjout($nom_table, addslashes($message));
        } else {
          echo "Erreur d'insertion";
        }
      }
    } elseif ($status == "update") {
      # code...
      $numero = $_POST["numero"];
      $verifNumero = $this->db->query("SELECT * FROM facture_article WHERE numero = '" . $numero . "' and id_fournisseur =" . $id_fournisseur . "")->result_array();
      if (count($verifNumero) > 0) {
        # code...

        foreach ($verifNumero as $row) {
          # code...
          if ($numero == $row['numero']) {
            # code...
            $update = $this->db->query("UPDATE facture_article set  id_fournisseur =" . $id_fournisseur . ",date_fact = CAST('" . $date . "' AS DATE),numero = '" . $numero . "',montant = " . $montant . ",remise = " . $remise . ",libelle='" . $numero . "',echeance = CAST('" . $echeance . "' AS DATE), cloture = 0 where numero='" . $numero . "'");
            if ($update == true) {
              # code...
              echo "Facture modifiée";
              $this->notificationAjout($nom_table, addslashes($message2));
            } else {
              echo "Erreur lors de la modification";
            }
          } else {
            if ($row['id_fournisseur'] == $id_fournisseur) {
              # code...
              echo "Ce numéro de facture est déjà utilisé par ce fournisseur veuillez changer";
            } else {
              $update = $this->db->query("UPDATE facture_article set  id_fournisseur =" . $id_fournisseur . ",date_fact = CAST('" . $date . "' AS DATE),numero = '" . $numero . "',montant = " . $montant . ",remise = " . $remise . ",libelle='" . $numero . "',echeance = CAST('" . $echeance . "' AS DATE), cloture = 0 where  numero='" . $numero . "'");
              if ($update == true) {
                # code...
                echo "Facture modifiée";
                $this->notificationAjout($nom_table, addslashes($message2));
              } else {
                echo "Erreur lors de la modification";
              }
            }
            // echo "Ce numéro de facture est déjà utilisé veuillez changer";
          }
        }
      } else {
        $update = $this->db->query("UPDATE facture_article set  id_fournisseur =" . $id_fournisseur . ",date_fact = CAST('" . $date . "' AS DATE),numero = '" . $numero . "',montant = " . $montant . ",remise = " . $remise . ",libelle='" . $numero . "',echeance = CAST('" . $echeance . "' AS DATE), cloture = 0 where numero='" . $numero . "'");
        if ($update == true) {
          # code...
          echo "Facture modifiée";
          $this->notificationAjout($nom_table, addslashes($message2));
        } else {
          echo "Erreur lors de la modification";
        }
      }
    } else {
      echo "Erreur fatale";
    }


    $this->db->close();
  }

  public function selectAllFacture()
  {
    $query1 = $this->db->query('SELECT * from  facture_article order by date_fact desc')->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...

      echo "<tr >
                    
                    <td> " . $compteur . "</td>";


      $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = " . $row["id_fournisseur"] . "")->row();

      echo "
                    <td>" . $row['numero'] . "</td>
                    <td> ";
      if (count($getFournisseur) > 0) {
        # code...
        echo $getFournisseur->nom;
      } else {
        echo "aucun";
      }
      echo " </td>
                    
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . number_format($row['remise'], 0, ',', ' ') . "</td>
                    
                    <td>" . $row['date_fact'] . " </td>
                    <td>" . $row['echeance'] . " </td>
                    
                    <td>";

      if ($this->session->userdata('article_modification') == 'true') {
        echo "<button type='button' onclick=\"infosFacture('" . $row['id_facture'] . "','" . $row['id_fournisseur'] . "','" . $row['numero'] . "','" . $row['date_fact'] . "','" . number_format($row['montant'], 0, ',', ' ') . "','" . $row['echeance'] . "', '" . $row['cloture'] . "', '" . number_format($row['remise'], 0, ',', ' ') . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
      }

      if ($this->session->userdata('article_suppression') == 'true') {
        echo " <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='" . $row['id_facture'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
      }
      $compteur++;
    }

    $this->db->close();
  }


  public function rapportFacture()
  {

    $id_fournisseur = $_POST['id_fournisseur'];

    $date_debut = $_POST['date_debut'];

    $date_fin = $_POST['date_fin'];

    $regler = $_POST['cloturer'];

    if ($date_debut != "" && $date_fin != "" && $id_fournisseur != "") {
      # code...

      $query1 = $this->db->query('SELECT * from  facture_article where date_fact between "' . $date_debut . '" and "' . $date_fin . '" and id_fournisseur = ' . $id_fournisseur . ' and cloture = ' . $regler . '  order by date_fact desc')->result_array();
    } elseif ($date_debut != "" && $date_fin != "" && $id_fournisseur == "") {
      # code...

      $query1 = $this->db->query('SELECT * from  facture_article where date_fact between "' . $date_debut . '" and "' . $date_fin . '" and cloture = ' . $regler . '  order by date_fact desc')->result_array();
    } else {

      $query1 = $this->db->query('SELECT * from  facture_article order by date_fact desc')->result_array();
    }

    $compteur = 0;
    $totalMontant = 0;
    $totalRemise = 0;
    $totalFacture = 0;

    if (count($query1) > 0) {
      # code...

      foreach ($query1 as $row) {
        # code...

        echo "<tr >
                    
                    ";


        $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = " . $row["id_fournisseur"] . "")->row();

        echo "
                    
                    <td> ";
        if (count($getFournisseur) > 0) {
          # code...
          echo $getFournisseur->nom;
        } else {
          echo "aucun";
        }

        $totalMontant = $row['montant'] + $totalMontant;

        $totalRemise = $row['remise'] + $totalRemise;

        $totaFacture = $row['montant'] - $row['remise'] + $totalFacture;

        echo " </td>
                    
                    <td>" . $row['libelle'] . "</td>
                    <td>" . $row['date_fact'] . " </td>
                    <td>" . $row['numero'] . "</td>
                    
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . number_format($row['remise'], 0, ',', ' ') . "</td>
                    <td>" . number_format($row['montant'] - $row['remise'], 0, ',', ' ') . "</td>
                    
                    <td>" . $row['echeance'] . " </td>
                    <td>" . $row['cloture'] . " </td>
                    
                  </tr>

                  ";
        $compteur++;
      }

      echo "<tr>
                <td style='color: red;'>TOTAL</td>
                <td></td>
                <td style='color: red;'></td>
                <td style='color: red;'></td>
                <td style='color: red;'>" . number_format($totalMontant, 0, ',', ' ') . "</td>
                <td style='color: red;'>" . number_format($totalRemise, 0, ',', ' ') . "</td>
                <td style='color: red;'>" . number_format($totalFacture, 0, ',', ' ') . "</td>
                <td></td>
                <td></td>
              </tr>
              ";
    }
    $this->db->close();
  }



  public function selectAllFactureParFournisseur()
  {

    $id_fournisseur = $_POST['id_fournisseur'];

    $query1 = $this->db->query('SELECT * from  facture_article where id_fournisseur =' . $id_fournisseur . ' order by date_fact desc')->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...
      $getCloture = $this->db->query("SELECT * from cloture_article where id_fournisseur_article = " . $id_fournisseur . " order by id_cloture desc limit 1")->row();
      if (count($getCloture) > 0) {
        # code...
        if ($row['date_fact'] > $getCloture->date_cloture) {
          # code...
          echo "<tr >
                    
                    <td> " . $compteur . "</td>";


          $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = " . $row["id_fournisseur"] . "")->row();

          echo "
                    <td>" . $row['numero'] . "</td>
                    <td> ";
          if (count($getFournisseur) > 0) {
            # code...
            echo $getFournisseur->nom;
          } else {
            echo "aucun";
          }
          echo " </td>
                    
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . $row['libelle'] . "</td>
                    <td>" . $row['date_fact'] . " </td>
                    <td>";

          if ($this->session->userdata('article_modification') == 'true') {
            echo "<button type='button' onclick=\"infosFacture('" . $row['id_facture'] . "','" . $row['numero'] . "','" . $row['date_fact'] . "','" . $row['libelle'] . "','" . number_format($row['montant'], 0, ',', ' ') . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
          }
          if ($this->session->userdata('article_suppression') == 'true') {
            echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='" . $row['id_facture'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
          }
          $compteur++;
        } else {
        }
      } else {
        echo "<tr >
                    
                    <td> " . $compteur . "</td>";


        $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = " . $row["id_fournisseur"] . "")->row();

        echo "
                    <td>" . $row['numero'] . "</td>
                    <td> ";
        if (count($getFournisseur) > 0) {
          # code...
          echo $getFournisseur->nom;
        } else {
          echo "aucun";
        }
        echo " </td>
                    
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . $row['libelle'] . "</td>
                    <td>" . $row['date_fact'] . " </td>
                    <td>";
        if ($this->session->userdata('article_modification') == 'true') {
          echo "
                    <button type='button' onclick=\"infosFacture('" . $row['id_facture'] . "','" . $row['numero'] . "','" . $row['date_fact'] . "','" . $row['libelle'] . "','" . number_format($row['montant'], 0, ',', ' ') . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
        }
        if ($this->session->userdata('article_suppression') == 'true') {
          echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='" . $row['id_facture'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
        }
        $compteur++;
      }
    }

    $this->db->close();
  }



  // nous passsons donc au règlement


  public function selectAllReglement()
  {
    $query1 = $this->db->query('SELECT * from reglement_article order by date_reg desc')->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...

      echo "<tr >
                    
                    <td> " . $compteur . "</td>
					
					<td>" . $row['type'] . "</td>
					
					<td> " . $row['date_reg'] . " </td>";

      $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = " . $row['id_fournisseur'] . "")->result_array();

      if (count($getOperation) > 0) {
        # code...
        foreach ($getOperation as $tab) {
          # code...
          echo "<td>" . $tab['nom'] . "</td>";
        }
      } else {
        # code...
        echo "<td></td>";
      }



      echo "
					
                    <td>" . $row['numero'] . "</td>
					<td>" . $row['cheque'] . "</td>
					<td>" . $row['banque'] . "</td>
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . $row['libelle'] . "</td>
					<td>" . $row['ciment'] . "</td>
					<td>" . $row['unitaire'] . "</td>
                    
                    <td>";
      if ($this->session->userdata('article_modification') == 'true') {
        echo "
                    <button type='button' onclick=\"infosReglement('" . $row['id_reglement'] . "','" . $row['id_fournisseur'] . "','" . $row['numero'] . "','" . $row['date_reg'] . "','" . number_format($row['montant'], 0, ',', ' ') . "','" . addslashes($row['libelle']) . "','" . addslashes($row['cheque']) . "','" . addslashes($row['banque']) . "','" . addslashes($row['ciment']) . "','" . addslashes($row['unitaire']) . "','" . addslashes($row['type']) . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
      }
      if ($this->session->userdata('article_suppression') == 'true') {
        echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='" . $row['id_reglement'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
      }
      $compteur++;
    }

    $this->db->close();
  }
  public function selectAllReglementParFournisseur()
  {
    $id_fournisseur = $_POST['id_fournisseur'];
    $query1 = $this->db->query("SELECT * from  reglement_article where id_fournisseur =" . $id_fournisseur . " order by date_reg desc")->result_array();
    $compteur = 0;
    foreach ($query1 as $row) {
      # code...
      $getCloture = $this->db->query("SELECT * from cloture_article where id_fournisseur_article = " . $id_fournisseur . " order by id_cloture desc limit 1")->row();
      if (count($getCloture) > 0) {
        // foreach ($query1 as $row) {
        # code...
        if (date("Y-m", strtotime($getCloture->date_cloture)) < date("Y-m", strtotime($row['date_reg']))) {
          # code...
          echo "<tr >
                    
                           <td> " . $compteur . "</td>
						   
						   <td>" . $row['type'] . "</td>
					
					<td> " . $row['date_reg'] . " </td>";

          $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = " . $row['id_fournisseur'] . "")->result_array();

          if (count($getOperation) > 0) {
            # code...
            foreach ($getOperation as $tab) {
              # code...
              echo "<td>" . $tab['nom'] . "</td>";
            }
          } else {
            # code...
            echo "<td></td>";
          }



          echo "
                    <td>" . $row['numero'] . "</td>
					<td>" . $row['cheque'] . "</td>
					<td>" . $row['banque'] . "</td>
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . $row['libelle'] . "</td>
					<td>" . $row['ciment'] . "</td>
					<td>" . $row['unitaire'] . "</td>
                    
                    <td>";
          if ($this->session->userdata('article_modification') == 'true') {
            echo "
                    <button type='button' onclick=\"infosReglement('" . $row['id_reglement'] . "','" . $row['id_fournisseur'] . "','" . $row['numero'] . "','" . $row['date_reg'] . "','" . number_format($row['montant'], 0, ',', ' ') . "','" . addslashes($row['libelle']) . "','" . addslashes($row['cheque']) . "','" . addslashes($row['banque']) . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
          }
          if ($this->session->userdata('article_suppression') == 'true') {
            echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='" . $row['id_reglement'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
          }
          $compteur++;
        }

        // }
      } else {
        foreach ($query1 as $row) {
          # code...

          echo "<tr >
                    
                          <td> " . $compteur . "</td>
					<td>" . $row['type'] . "</td>
					<td> " . $row['date_reg'] . " </td>";

          $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = " . $row['id_fournisseur'] . "")->result_array();

          if (count($getOperation) > 0) {
            # code...
            foreach ($getOperation as $tab) {
              # code...
              echo "<td>" . $tab['nom'] . "</td>";
            }
          } else {
            # code...
            echo "<td></td>";
          }



          echo "
                    <td>" . $row['numero'] . "</td>
					<td>" . $row['cheque'] . "</td>
					<td>" . $row['banque'] . "</td>
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td>" . $row['libelle'] . "</td>
					<td>" . $row['ciment'] . "</td>
					<td>" . $row['unitaire'] . "</td>
                    
                    <td>";
          if ($this->session->userdata('article_modification') == 'true') {
            echo "
                    <button type='button' onclick=\"infosReglement('" . $row['id_reglement'] . "','" . $row['id_fournisseur'] . "','" . $row['numero'] . "','" . $row['date_reg'] . "','" . number_format($row['montant'], 0, ',', ' ') . "','" . addslashes($row['libelle']) . "','" . addslashes($row['cheque']) . "','" . addslashes($row['banque']) . "')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
          }
          if ($this->session->userdata('article_suppression') == 'true') {
            echo "
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='" . $row['id_reglement'] . "' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
          }
          $compteur++;
        }
      }
    }

    $this->db->close();
  }

  public function addReglement()
  {

    $status = $_POST["status"];
    $numero = $_POST["numero"];
    $montant = preg_replace('/\s/', '', $_POST["montant"]);
    $ciment = preg_replace('/\s/', '', $_POST["ciment"]);
    $unitaire = preg_replace('/\s/', '', $_POST["unitaire"]);

    $date = $_POST["date"];
    $libelle = addslashes($_POST["libelle"]);
    $cheque = addslashes($_POST["cheque"]);
    $banque = addslashes($_POST["banque"]);

    $validite = $_POST["validite"];
    $id_fournisseur = $_POST["id_fournisseur"];

    $nom_table = "reglement_article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté un règlement article N°" . $numero . ", d'un montant" . $montant . ",  le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié un règlement article caisse N°" . $numero . ", d'un montant" . $montant . ",  le " . $date_notif . " à " . $heure;


    if ($status == "insert") {
      # code...
      $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '" . $numero . "' and id_fournisseur =" . $id_fournisseur . "")->row();
      if (count($verifNumero) > 0) {
        # code...
        // echo "Ce numéro de règlement est déjà utilisé veuillez changer";
        if ($verifNumero->id_fournisseur == $id_fournisseur) {
          # code...
          echo "Ce numéro de règlement est déjà utilisé par ce fournisseur veuillez changer";
        } else {
          $insertFacture = $this->db->query("INSERT INTO reglement_article value(''," . $id_fournisseur . ",'" . $numero . "',CAST('" . $date . "' AS DATE)," . $montant . ",'" . $libelle . "','" . $cheque . "','" . $banque . "'," . $ciment . "," . $unitaire . ",'" . $validite . "',0)");
          if ($insertFacture == true) {
            # code...
            echo "Règlement de la facture effectué";
            $this->notificationAjout($nom_table, addslashes($message));
          } else {
            echo "Erreur d'insertion";
          }
        }
      } else {

        $insertFacture = $this->db->query("INSERT INTO reglement_article value(''," . $id_fournisseur . ",'" . $numero . "',CAST('" . $date . "' AS DATE)," . $montant . ",'" . $libelle . "','" . $cheque . "','" . $banque . "'," . $ciment . "," . $unitaire . ",'" . $validite . "',0)");
        if ($insertFacture == true) {
          # code...
          echo "Règlement de la facture effectué";
          $this->notificationAjout($nom_table, addslashes($message));
        } else {
          echo "Erreur d'insertion";
        }
      }
    } elseif ($status == "update") {
      # code...
      $id_facture = $_POST["id_facture"];
      $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '" . $numero . "' and id_fournisseur =" . $id_fournisseur . "")->result_array();
      if (count($verifNumero) > 0) {
        # code...

        foreach ($verifNumero as $row) {
          # code...

          $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =" . $id_fournisseur . ",date_reg = CAST('" . $date . "' AS DATE),numero = '" . $numero . "',montant = " . $montant . ",libelle='" . $libelle . "',cheque='" . $cheque . "',banque='" . $banque . "' ,ciment = " . $ciment . ", unitaire = " . $unitaire . ",type = '" . $validite . "' where id_reglement=" . $id_facture . "");

          if ($update == true) {
            # code...
            echo "Règlement modifié";
            $this->notificationAjout($nom_table, addslashes($message2));
          } else {
            echo "Erreur lors de la modification";
          }
        }
      } else {
        $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =" . $id_fournisseur . ",date_reg = CAST('" . $date . "' AS DATE),numero = '" . $numero . "',montant = " . $montant . ",libelle='" . $libelle . "',cheque='" . $cheque . "',banque='" . $banque . "' ,ciment = " . $ciment . ", unitaire = " . $unitaire . ",type = '" . $validite . "' where id_reglement=" . $id_facture . "");

        if ($update == true) {
          # code...
          echo "Règlement modifié";
          $this->notificationAjout($nom_table, addslashes($message2));
        } else {
          echo "Erreur lors de la modification";
        }
      }
    }

    $this->db->close();
  }

  public function leSelectFacture()
  {
    $getGazoil = $this->db->query("SELECT * FROM facture_article ")->result_array();

    if (count($getGazoil) > 0) {
      # code...
      foreach ($getGazoil as $row) {
        # code...
        echo "<option value='" . $row['id_facture'] . "'> " . $row['numero'] . " </option>";
      }
    }
  }



  public function selectAllFacturePourBalance()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="' . $date_debut . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "' . $date_debut . '" and "' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "' . $date_debut . '" and "' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_debut . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    }
    $compteur = 0;
    $montant = 0;
    foreach ($query1 as $row) {
      # code...

      echo "<tr >
                    
                    <td> " . $compteur . "</td>";

      echo "
                    <td>" . $row['numero'] . "</td>
                    <td>" . number_format($row['montant'], 0, ',', ' ') . "</td>
                    <td> " . $row['date_fact'] . " </td>
                   
                  </tr>

                  ";
      $montant = $montant + $row['montant'];

      $compteur++;
    }

    $this->db->close();
  }

  public function selectAllTotalFacturePourBalanceFournisseur()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="' . $date_debut . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "' . $date_debut . '" and "' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "' . $date_debut . '" and "' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="' . $date_debut . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    }
    $compteur = 0;
    $montant = 0;
    foreach ($query1 as $row) {
      # code...
      $montant = $montant + $row['montant'];
    }
    return $montant;

    $this->db->close();
  }



  public function selectAllReglementPourBalance()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  date_reg>="' . $date_debut . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "' . $date_debut . '" and "' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "' . $date_debut . '" and "' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_debut . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    }
    $compteur = 0;
    $montant = 0;
    foreach ($query1 as $tab) {
      # code...
      echo "<tr >
                    
                    <td> " . $compteur . "</td>";

      echo "
                                <td>" . $tab['numero'] . "</td>
                                <td>" . number_format($tab['montant'], 0, ',', ' ') . "</td>
                                <td> " . $tab['date_reg'] . " </td>
                                
                              </tr>

                              ";

      $compteur++;
      $montant = $montant + $tab['montant'];
    }
    $this->db->close();
  }
  public function selectAllTotalReglementPourBalanceFournisseur()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  date_reg>="' . $date_debut . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "' . $date_debut . '" and "' . $date_fin . '"')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "' . $date_debut . '" and "' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_fin . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    } elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
      # code...
      $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="' . $date_debut . '" and id_fournisseur=' . $id_fournisseur . '')->result_array();
    }
    $compteur = 0;
    $montant = 0;
    foreach ($query1 as $tab) {

      $montant = $montant + $tab['montant'];
    }
    return $montant;

    $this->db->close();
  }

  public function soldeCaisseFournisseur()
  {
    echo $this->selectAllTotalFacturePourBalanceFournisseur() - $this->selectAllTotalReglementPourBalanceFournisseur();
  }

  public function getSoldeArticle()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_article = date("Y-m", strtotime($_POST["date_article"]));

    $query1 = $this->db->query('SELECT * FROM facture_article where date_fact like "%' . $date_article . '%" and id_fournisseur=' . $id_fournisseur . '')->result_array();


    $montant = 0;
    foreach ($query1 as $row) {
      # code...
      $montant = $montant + $row["montant"];

      $this->db->close();
    }


    $query2 = $this->db->query('SELECT * FROM reglement_article where date_reg like "%' . $date_article . '%" and id_fournisseur=' . $id_fournisseur . '')->result_array();


    $montant2 = 0;
    foreach ($query2 as $row) {
      # code...
      $montant2 = $montant2 + $row["montant"];
    }

    echo number_format($montant - $montant2, 0, ',', ' ') . " FCFA";

    $this->db->close();
  }


  public function getTotalReglement()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_article = date("Y-m", strtotime($_POST["date_article"]));

    $query1 = $this->db->query('SELECT * FROM reglement_article where date_reg like "%' . $date_article . '%" and id_fournisseur=' . $id_fournisseur . '')->result_array();

    $montant = 0;
    foreach ($query1 as $row) {
      # code...
      $montant = $montant + $row["montant"];
    }

    echo number_format($montant, 0, ',', ' ') . " FCFA";

    $this->db->close();
  }


  public function getTotalFacture()
  {
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_article = date("Y-m", strtotime($_POST["date_article"]));
    $query2 = $this->db->query('SELECT * FROM facture_article where date_fact like "%' . $date_article . '%" and id_fournisseur=' . $id_fournisseur . '')->result_array();

    $montant = 0;
    foreach ($query2 as $row) {
      # code...
      $montant = $montant + $row["montant"];
    }

    echo number_format($montant, 0, ',', ' ') . " FCFA";

    $this->db->close();
  }


  public function getValiditeDate2($date, $id_fournisseur)
  {
    $getDelai = $this->db->query("SELECT * from cloture_article  where date_cloture like '%" . $date . "%' and id_fournisseur_article=" . $id_fournisseur . " and cloture =1 order by date_cloture desc limit 1")->row();

    if (count($getDelai) > 0) {
      # code...
      return true;
      // if ($getDelai->date_cloture == $date) {
      //     # code...
      //     return true;
      // }else{
      //     return false;
      // }
    } else {
      // $getLastDateCloture = $this->db->query("SELECT * from cloture_caisse order by id_cloture desc ")->row();
      // return $getDelai->date_cloture;
      return false;
    }
    $this->db->close();
  }
  public function demandeClotureMois($date_cloture)
  {
    date_default_timezone_set('Africa/Lagos');
    $date_prec = date("Y-m", strtotime($date_cloture . '- 1 month'));

    // echo " la date est: ".$date_prec;

    $query = $this->db->query("SELECT * from cloture_article where date_cloture like '%" . $date_prec . "%' and cloture =1")->row();
    if (count($query) > 0) {
      # code...
      return true;
    } else {

      return false;
    }
    $this->db->close();
  }
  public function addClotureArticle()
  {
    $date_cloture = $_POST["date_cloture"];

    $facture =  intval(preg_replace('/\s/', '', $_POST["facture"]));
    $reglement = intval(preg_replace('/\s/', '', $_POST["reglement"]));
    $solde = intval(preg_replace('/\s/', '', $_POST["solde"]));
    $cloturer = $_POST["cloturer"];
    $ordonateur = $_POST['ordonateur'];
    $id_fournisseur = $_POST['id_fournisseur'];
    $status = $_POST["status"];


    $nom_table = "cloture_article";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à ajouté une cloture article d'une facturee de " . $facture . ",d'un règlement de " . $reglement . ", pour un solde de " . $solde . " ordonné par " . $ordonateur . ",  le " . $date_notif . " à " . $heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à modifié une cloture article d'une facturee de " . $facture . ",d'un règlement de " . $reglement . ", pour un solde de " . $solde . " ordonné par " . $ordonateur . ",  le " . $date_notif . " à " . $heure;


    if ($solde > 0 || $solde < 0) {
      # code...
      echo "Le solde de ce fournisseur doit etre de 0 FCFA pour cloturer";
    } else {

      if ($status == "insert") {
        # code...
        if ($this->getValiditeDate2(date("Y-m", strtotime($date_cloture)), $id_fournisseur) == true) {
          # code...
          echo "Entrez une date supérieure à celle de la dernière cloture pour ce fournisseur";
        }
        // elseif ($this->demandeClotureMois($date_cloture) == false) {
        //     # code...
        //     echo "Veuillez d'abord cloturer le mois précédent".date("Y-m",strtotime($date_cloture.'- 1 month'));
        // }
        else {
          $insertion = $this->db->query("INSERT INTO cloture_article value(''," . $id_fournisseur . ",CAST('" . $date_cloture . "' AS DATE)," . $facture . "," . $reglement . "," . $solde . ",'" . $ordonateur . "'," . $cloturer . ")");
          if ($insertion == true) {
            # code...
            echo "Cloture effectuée";
            $this->notificationAjout($nom_table, addslashes($message));
          } else {
            echo "Erreur de cloture contactez l'administrateur";
          }
        }
      } elseif ($status == "update") {
        # code...
        $ancienne_date = $_POST["ancienne_date"];
        if ($date_cloture == $ancienne_date) {
          # code...

          $id_cloture = $_POST["id_cloture"];

          $update = $this->db->query("UPDATE cloture_article set id_fournisseur=" . $id_fournisseur . ", date_cloture=CAST('" . $date_cloture . "' AS DATE),facture=" . $facture . ",reglement=" . $reglement . ",solde=" . $solde . ",ordonateur='" . $ordonateur . "' where id_cloture = " . $id_cloture . "");
          if ($update == true) {
            # code...

            echo "Modification parfaite de la cloture";
            $this->notificationAjout($nom_table, addslashes($message2));
          } else {

            echo "Erreur de modification";
          }
        } else {
          $getDelai = $this->db->query("SELECT * from cloture_article  where date_cloture='" . $date_cloture . "' and cloture =1 order by date_cloture desc limit 1")->row();
          if (count($getDelai) > 0) {
            # code...
            echo "Une cloture a déjà été éffectuée à cette date veuillez changer";
          } else {

            $id_cloture = $_POST["id_cloture"];

            $update = $this->db->query("UPDATE cloture_article set id_fournisseur=" . $id_fournisseur . ", date_cloture=CAST('" . $date_cloture . "' AS DATE),facture=" . $facture . ",reglement=" . $reglement . ",solde=" . $solde . ",ordonateur='" . $ordonateur . "' where id_cloture = " . $id_cloture . "");
            if ($update == true) {
              # code...

              echo "Modification parfaite de la cloture";
              $this->notificationAjout($nom_table, addslashes($message2));
            } else {

              echo "Erreur de modification";
            }
          }
        }
      } else {
        echo "Erreur fatale contactez l'administrateur";
      }
    }
    $this->db->close();
  }

  public function selectAllClotureArticle()
  {
    $query = $this->db->query("SELECT * from cloture_article order by date_cloture  desc")->result_array();

    if (count($query) > 0) {
      # code...
      $compteur = 0;
      foreach ($query as $row) {
        # code...
        $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur=" . $row['id_fournisseur_article'] . "")->row();
        echo "<tr >
                    <td onclick=\"creerDatable();\">" . $compteur . "</td>
                   
                    <td>" . $getFournisseur->nom . "</td>
                    <td>" . $row['date_cloture'] . "</td>
                    <td> " . number_format($row['facture'], 0, ',', ' ') . "</td>
                    <td> " . number_format($row['reglement'], 0, ',', ' ') . "</td>
                    <td> " . number_format($row['solde'], 0, ',', ' ') . "</td>
                    <td>" . $row['ordonateur'] . "</td>
                   
                  </tr>

                  ";
        // <td>
        // <button type='button' onclick='infosClotureCaisse(\"".$row['date_cloture']."\",\"".$row['date_cloture']."\",\"".number_format($row['total_entree'],0,',',' ')." FCFA\",\"".number_format($row['total_sortie'],0,',',' ')." FCFA\",\"".number_format($row['solde'],0,',',' ')." FCFA\",\"".$row['ordonateur']."\",\"".$row['id_cloture']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>

        // </td>
        $compteur++;
      }
    }

    $this->db->close();
  }

  public function deleteFournisseurArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé le fournisseur article " . $getCamion->nom . " de téléphone " . $getCamion->telephone . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }

  public function getFournisseurArticle($id_fournisseur)
  {
    $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = " . $id_fournisseur . "")->row();

    if (count($query) > 0) {
      # code...
      return $query->nom;
    }
  }
  public function deleteFactureFournisseurArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé la facture fournisseur article " . $this->getFournisseurArticle($getCamion->id_fournisseur) . ", de N° " . $getCamion->numero . " d'un montant d'un " . $getCamion->montant . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }


  public function deleteReglementFournisseurArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé le règlement fournisseur article de  " . $this->getFournisseurArticle($getCamion->id_fournisseur) . ", de N° " . $getCamion->numero . " d'un montant d'un " . $getCamion->montant . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }

  public function deleteArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé l'article de  " . $getCamion->article . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }


  public function deleteCLotureArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé la cloture  article du fournisseur  " . $this->getFournisseurArticle($getCamion->id_fournisseur) . ", d'ordonateur " . $getCamion->ordonateur . " dont le solde était " . $getCamion->solde . ", de la date du " . $getCamion->date_cloture . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }
  public function deleteTypeArticle($table, $identifiant, $nom_id)
  {

    $getCamion = $this->db->query("SELECT * from " . $table . " where " . $nom_id . "=" . $identifiant . "")->row();

    if (count($getCamion) > 0) {
      # code...
      $nom_table = $table;
      $heure = date("H:i:s");
      $date_notif = date("d-m-Y");
      $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil')) . " à supprimé la catégorie article " . $getCamion->categorie . " le " . $date_notif . " à " . $heure;


      $suppression = $this->db->query("delete from " . $table . " where " . $nom_id . "=" . $identifiant . "");
      if ($suppression == true) {
        # code...
        echo "Suppression effectuée";
        $this->notificationAjout($nom_table, addslashes($message));
      } else {
        echo "Erreur lors de la suppression";
      }
    }


    $this->db->close();
  }

  public function genererChaineAleatoireReglementArticle()
  {

    $date = date('Y-m-d');
    $now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from reglement_article order by id_reglement desc limit 1")->row();

    $code = 0;
    if (count($getCodeBLClient) > 0) {
      # code...
      $code = $getCodeBLClient->numero;
    } else {

      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code) < 10) {
      # code...
      $code = "0" . $code;
    }

    return "REGFA" . filter_var($code, FILTER_SANITIZE_NUMBER_INT);
  }
}
