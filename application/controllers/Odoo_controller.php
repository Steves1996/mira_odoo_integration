<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Odoo_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('crud_model_article');
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

    function jsonDeserialisation($json, $jsonKey)
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Erreur de décodage JSON : ' . json_last_error_msg();
        }
        if (isset($data[$jsonKey]) && is_array($data[$jsonKey])) {
            return $data[$jsonKey][0]['id'];
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




    public function AddPaimentFournisseurInOdoo()
    {
        $partnerData = $this->getPartnerInOdoo('ABS CAMEROUN SARL');

        echo "partnerid: $partnerData";

        if ($partnerData != null) {
            $postParameter = array(
                'fields' => [
                    'payment_type', 'partner_id', 'amount', 'partner_type'
                ],
                'values' => [
                    'payment_type' => 'outbound',
                    'partner_type' => 'supplier',
                    'partner_id' => $partnerData,
                    'amount' => 90000
                ]
            );
            //'amount' => $this->crud_model_article->getBalanceImprimableClient()
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

            curl_close($ch);


            $idPayment = $this->jsonDeserialisation($response, 'New resource');


            $this->AddAccountMoveOdoo($partnerData, 'entry', $idPayment);

            return $response;
        }
    }




    public function AddAccountMoveOdoo($partner_id, $move_type, $id)
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

    public function AddPaimentClientInOdoo($name)
    {
        $partnerData = $this->getPartnerInOdoo($name);

        if ($partnerData != null) {
            $postParameter = array(
                'fields' => [
                    'payment_type', 'partner_id', 'amount', 'partner_type'
                ],
                'values' => [
                    'payment_type' => 'inbound',
                    'partner_type' => 'customer',
                    'partner_id' => $this->$partnerData->records[0]->id,
                    'amount' => $this->crud_model_article->getBalanceImprimableClient()
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
            curl_close($ch);

            return $response;
        }
    }
}
