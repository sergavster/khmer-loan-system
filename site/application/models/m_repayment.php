<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('Permission Denied!');

class m_repayment extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    /**
     * 
     */
//    function select_count_trn() {
//        $data['total_debit'] = $this->db->select('SUM(tra_debit) as debit_total');
//        $data['total_credit'] = $this->db->select('SUM(tra_credit) as credit_total');
//        return $data;
//    }
    public function getRepay() {
        $new_date = "";
        $datestring = "%Y-%m-%d";
        $time = time();
        $stringDate = mdate($datestring, $time);
        
        ///============Filtter========================
        if ($this->input->post('date')) {
            $col_date = $this->input->post('date');
            $new_date = date("Y-m-d", strtotime($col_date));
            $stringDate = $new_date;
        } else {
            $new_date = "CURDATE()";
        }

        if ($this->input->post('co_name')) {
            $co_id = $this->input->post('co_name');
            $this->db->where('loa.loa_acc_co_id', "$co_id", true);
        }

        $this->db->where('rep_sch_date_repay', "$new_date", true);
        $this->session->set_userdata('col_date', $stringDate);
        
        $this->db->where('loa.loa_acc_loa_det_id', 2, true); /////when laon is approved only
        $this->db->select('*');
        $this->db->select('CONCAT(con.con_en_first_name,' . ',con.con_en_last_name) as en_name', FALSE);
        $this->db->select('CONCAT(con.con_kh_first_name,' . ',con.con_kh_last_name) as kh_name', FALSE);
        $this->db->from('repayment_schedule rps');
        $this->db->join('loan_account loa', 'loa.loa_acc_id=rps.rep_sch_loa_acc_id');
        $this->db->join('creadit_officer co', 'loa.loa_acc_co_id=co.co_id');
        $this->db->join('repayment_status reps', 'reps.rep_sta_id=rps.rep_sch_status');
        $this->db->join('contacts con', 'con.con_id=loa.loa_acc_con_id');
        $this->db->join('contacts_job conj', 'conj.con_job_id=con.con_con_job_id');
        $this->db->join('contacts_type cont', 'con.con_con_typ_id=cont.con_typ_id');
        $this->db->join('contacts_detail cond', 'con.con_id=cond.con_det_con_id');
//        $this->db->group_by('rep_sch_loa_acc_id');
        $query = $this->db->get();
        return $query;
    }

    public function sum_balance($arr_item_where = NULL) {
        if ($arr_item_where != NULL) {
            foreach ($arr_item_where as $field => $value) {
                $data['balance'] = $this->db->where($field, $value);
            }
        }
        $data['balance'] = $this->db->select('SUM(tra_debit) as debit_total,SUM(tra_credit) as credit_total');
        return $data;
    }

    public function get_contact_info($sum_query = NULL) {
        $this->db->where('loa_status', 0);
        $this->db->select('*');
        $this->db->join('contacts_detail', 'con_id=con_det_con_id');
        $this->db->join('contacts_type', 'con_con_typ_id=con_typ_id');
        $this->db->join('loan_account', 'loan_account.loa_acc_con_id=contacts.con_id', 'left');
//        ============ More detail about contact ============
        $this->db->join('provinces', 'contacts_detail.con_det_pro_id=provinces.pro_id', 'left');
        $this->db->join('districts', 'contacts_detail.con_det_dis_id=districts.dis_id', 'left');
        $this->db->join('communes', 'contacts_detail.con_det_com_id=communes.com_id', 'left');
        $this->db->join('villages', 'contacts_detail.con_det_vil_id=villages.vil_id', 'left');
        $this->db->join('repayment_schedule', 'loan_account.loa_acc_id=repayment_schedule.rep_sch_loa_acc_id', 'inner');

        $this->db->select_sum('rep_sch_rate_repayment', 'total_rate');
        $this->db->group_by('rep_sch_loa_acc_id');

        $query = $this->db->get('contacts');
        return $query;
    }

}

?>
