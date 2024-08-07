<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Odoo_model extends CI_Model
{
    // 
    function __construct()
    {
        parent::__construct();
        // $this->load->database('default');
        $this->load->library('session');
        // $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
    }

    public function getFournisseurInfos($id)
    {
        $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=" . $id . "")->row();
        if (count($query) > 0) {
            return $query->nom;
        }
        $this->db->close();
    }
}
