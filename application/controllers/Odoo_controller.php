<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Odoo_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('crud_model_article');
        $this->load->model('Odoo_model');
    }

    public function index()
    {
        $this->load->view('documentADM/balance_imprimable_fournisseur');
    }

    public function databaseOdooConnect()
    {
        return [
            'Content-Type:application/json',
            'db:miradb',
            'login:steveskamdem6@gmail.com',
            'password:Allen1205@',
            'api_key:fa2d14dc-afb5-40cb-b214-85091b09af69'
        ];
    }

    public function getUrlForConnectionToDataTable($dataTable)
    {
        return "http://localhost:8069/send_request?model=$dataTable";
    }

    function getIdByName($json, $nameToFind)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Erreur de décodage JSON : ' . json_last_error_msg();
        }
        if (isset($data['records']) && is_array($data['records'])) {
            foreach ($data['records'] as $record) {
                if (isset($record['name']) && $record['name'] === $nameToFind) {
                    return $record['id'];
                }
            }
            return 'Nom non trouvé';
        } else {
            return 'Le champ "records" est manquant ou n\'est pas un tableau';
        }
    }

    function jsonDeserialisation($json, $jsonKey, $key = 'id')
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Erreur de décodage JSON : ' . json_last_error_msg();
        }
        if (isset($data[$jsonKey]) && is_array($data[$jsonKey])) {
            return $data[$jsonKey][0][$key];
        } else {
            return null;
        }
    }


    public function getPartnerInOdoo($name)
    {
        $fournisseurDataTable = $this->getUrlForConnectionToDataTable('res.partner');

        $ch = curl_init($fournisseurDataTable);

        //header connection tu data base curl
        $headers = $this->databaseOdooConnect();
        $getParameter = array(
            'fields' => [
                'name',
            ]
        );

        $dataToGet = json_encode($getParameter);
        //set opt
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToGet);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);

        $dataReturn = $this->getIdByName($response, $name);
        curl_close($ch);

        return $dataReturn;
    }


    public function getLastPaymentInOdoo($idPayment)
    {
        $fournisseurDataTable = $this->getUrlForConnectionToDataTable('account.payment');
        $fournisseur_paiement_url = "$fournisseurDataTable&Id=$idPayment";
        $ch = curl_init($fournisseur_paiement_url);

        //header connection tu data base curl
        $headers = $this->databaseOdooConnect();
        $getParameter = array(
            'fields' => [
                'move_id',
            ]
        );

        $dataToGet = json_encode($getParameter);
        //set opt
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToGet);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        echo "\nget move ID of last pay: $response";

        $moveId = $this->jsonDeserialisation($response, 'records', 'move_id');
        $dataMoveId = $moveId[0];
        curl_close($ch);

        return $dataMoveId;
    }

    public function addPartnerInOdoo($partnerName)
    {
        $postParameter = array(
            'fields' => [
                'name', "is_company"
            ],
            'values' => [
                'name' => $partnerName,
                "is_company" => true
            ]
        );
        //'amount' => $this->crud_model_article->getBalanceImprimableClient()
        //Odoo
        $dataToSave = json_encode($postParameter);

        $fournisseurPaiementDataTable = $this->getUrlForConnectionToDataTable('res.partner');
        $fournisseur_paiement_url = "$fournisseurPaiementDataTable";

        $ch = curl_init($fournisseur_paiement_url);

        //header curl
        $headers = $this->databaseOdooConnect();

        //set opt
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSave);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);


        curl_close($ch);

        return $response;
    }


    public function AddPaimentFournisseurInOdoo()
    {
        $id_partner = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        $namePartner = $this->Odoo_model->getFournisseurInfos($id_partner);
        $partnerData = $this->getPartnerInOdoo($namePartner);
        $amount = $this->crud_model_article->getBalanceImprimablePartnerForOdoo($id_partner, $date_debut, $date_fin);

        if (is_numeric($partnerData)) {
            $postParameter = array(
                'fields' => [
                    'payment_type', 'partner_id', 'amount', 'partner_type'
                ],
                'values' => [
                    'payment_type' => 'outbound',
                    'partner_type' => 'supplier',
                    'partner_id' => $partnerData,
                    'amount' => $amount
                ]
            );
            //Odoo
            $dataToSave = json_encode($postParameter);

            $fournisseurPaiementDataTable = $this->getUrlForConnectionToDataTable('account.payment');
            $fournisseur_paiement_url = "$fournisseurPaiementDataTable";

            $ch = curl_init($fournisseur_paiement_url);

            //header curl
            $headers = $this->databaseOdooConnect();

            //set opt
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSave);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            $idPayment = $this->jsonDeserialisation($response, 'New resource');

            $moveId = $this->getLastPaymentInOdoo($idPayment);
            if (isset($moveId)) {
                $this->updateAccountMoveOdoo($partnerData, 'entry', $moveId);
            }

            curl_close($ch);

            return $response;
        } else {
            echo "\nnot vendor: $partnerData";

            $addpartner = $this->addPartnerInOdoo($namePartner);
            if (isset($addpartner)) {
                $responsePayVendor = $this->AddPaimentFournisseurInOdoo();
            }
            return $responsePayVendor;
        }
    }


    public function updateAccountMoveOdoo($partner_id, $move_type, $id)
    {
        $postParameter = array(
            'fields' => [
                'partner_id', 'commercial_partner_id', 'state', 'move_type'
            ],
            'values' => [
                'state' => 'posted',
                'commercial_partner_id' => $partner_id,
                'partner_id' => $partner_id,
                'move_type' => $move_type
            ]
        );

        //Odoo
        $dataToSave = json_encode($postParameter);

        $fournisseurPaiementDataTable = $this->getUrlForConnectionToDataTable('account.move');
        $fournisseur_paiement_url = "$fournisseurPaiementDataTable&Id=$id";

        $ch = curl_init($fournisseur_paiement_url);

        //header curl
        $headers = $this->databaseOdooConnect();

        //set opt
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSave);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function AddPaimentClientInOdoo()
    {
        $id_partner = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        $namePartner = $this->Odoo_model->getClientInfos($id_partner);
        $partnerData = $this->getPartnerInOdoo($namePartner);
        $amount = $this->crud_model_article->getBalanceImprimablePartnerForOdoo($id_partner, $date_debut, $date_fin);

        if (is_numeric($partnerData)) {
            $postParameter = array(
                'fields' => [
                    'payment_type', 'partner_id', 'amount', 'partner_type'
                ],
                'values' => [
                    'payment_type' => 'inbound',
                    'partner_type' => 'customer',
                    'partner_id' => $partnerData,
                    'amount' => $amount
                ]
            );
            //Odoo
            $dataToSave = json_encode($postParameter);

            $fournisseurPaiementDataTable = $this->getUrlForConnectionToDataTable('account.payment');
            $fournisseur_paiement_url = "$fournisseurPaiementDataTable";

            $ch = curl_init($fournisseur_paiement_url);

            //header curl
            $headers = $this->databaseOdooConnect();

            //set opt
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSave);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            $idPayment = $this->jsonDeserialisation($response, 'New resource');

            $moveId = $this->getLastPaymentInOdoo($idPayment);
            if (isset($moveId)) {
                $this->updateAccountMoveOdoo($partnerData, 'entry', $moveId);
            }

            curl_close($ch);

            return $response;
        } else {
            echo "\nnot vendor: $partnerData";

            $addpartner = $this->addPartnerInOdoo($namePartner);
            if (isset($addpartner)) {
                $responsePayVendor = $this->AddPaimentFournisseurInOdoo();
            }
            return $responsePayVendor;
        }
    }
}
