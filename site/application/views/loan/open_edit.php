<?php
if ($this->session->flashdata('success'))
    echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
//echo form_open(site_url(segment(1) . 'loan/edit'), array('class' => 'form-horizontal', 'name' => 'open_loan', 'id' => 'form_loan'));
//echo form_open_multipart(($edit == 0) ? 'loan/add' : 'loan/edit', array('class' => 'form-horizontal', 'name' => 'open_loan', 'id' => 'form_loan'));
echo form_open_multipart('loan/edit', array('class' => 'form-horizontal', 'name' => 'open_loan', 'id' => 'form_loan'));

////echo form_hidden('gl_list', $gl);
// Get Laon Account infimation
$list_acc_number = "";
$list_acc_number .= '<datalist id="gl_code">';
foreach ($acc_num_query->result() as $acc_num_rows) {

    $list_acc_number .='<option value="' . $acc_num_rows->loa_acc_code . '">';
// $list_acc_number .='<option value="'.$gl_rows->gl_code.'">'.$gl_rows->gl_description.'</option>'; 
}
$list_acc_number.= '</datalist>';
?>
<div class="row form-container">
    <div class="form_model_style"></div>
    <div class="loan_style">
        <?php
        if ($edit == 0) {
            $i = 0;
            $typethread = NULL;
            foreach ($contacts->result() as $row) {

                echo form_hidden('_' . $row->con_cid, $row->con_id);
                if ($i == 0) {
                    $typethread .= '["' . $row->con_cid . '"';
                } else {
                    $typethread .= ',"' . $row->con_cid . '"';
                }
                $i++;
            }
            $i = 0;
            $typethread .= ']';
        }


        echo open_span(5);
        echo open_block('cutomer_info', 'Customer information');
        field("text", "account_number", "Accoundt Number: ", NULL, array('attribute' => array('list' => "list_account_number", 'class' => 'numeric', 'id' => "account_number", 'style' => "width:124px;"))
                , TRUE, '<datalist id="list_account_number">' . $list_acc_number . '</datalist>
<a class="btn account_number btn_search_gl gl_code" style=" padding: 4px 8px;"  id="search_customer_by_code" href="#"><i class="icon-search loader"></i> Search</a>');
        echo '<span id="account_number_des"></span>'; ///=========View Saving account information ===============//
        acc_info("", 'loa_info');
        echo "<span class='acc_info_des'>";

        acc_info('CID', 'view_con_cid');
        ?>
        <div class="control-group">
            <div class="controls">


                <?php
//                echo form_hidden('cid', set_value('cid'));
                echo form_hidden('con_id', set_value('con_id'));
                echo form_hidden('loa_id', set_value('loa_id'));
                echo '<span class="error">' . form_error('con_id') . '</span>';
                ?>
            </div>
        </div>               
        <?php
        acc_info('Display name', 'displayname');

        acc_info('Date of birth', 'con_dob');

        acc_info('Address', 'con_address');

        echo "<div id='c_info'></div>";
        echo "</span>";
        echo close_block();
//-----------------------------


        echo open_block('product_detail', 'Product Detail');
        $product_type[''] = '---Select product type---';

//        echo get_form($data);
        field('select', 'loa_acc_loa_pro_typ_id', 'Product type:', NULL, array('options' => $product_type, 'attribute' => array('validated' => 1)), TRUE);
        field('select', 'co_id', 'CO Name:', NULL, array('options' => $co_data, 'attribute' => array('validated' => 1)), TRUE);

        $schedule_type = array(
            '' => '---Select schedule type---',
            1 => 'Anuity',
            2 => 'Declining'
        );
//        $schedule_type[''] = '---Select schedule type---';
        field('select', 'loa_sch_id', 'Repayment type:', NULL, array('options' => $schedule_type, 'attribute' => array('validated' => 1)), TRUE);


        echo close_block();
        echo close_span();
// End Left

        echo open_span(5);
        echo open_block('general_info', 'Loan Specs');
//-----------------------------
        $won_type = array('' => '---Select Ownership Type---', 1 => 'Sigle', 2 => 'Group');

        field('select', 'won_type', 'Ownership Type:', NULL, array('options' => $won_type, 'attribute' => array('id' => 'won_type')), TRUE);


//        field('select', 'gl_code', 'GL Code :', NULL, array('options' => $gl, 'attribute' => array('id' => 'gl_code')), TRUE); //// Not need for this time 
//echo form_hidden('gl_id');
        field('select', 'lat_id', 'លេខគណនីអតិថិជន :', NULL, array('options' => $loan_account_type, 'attribute' => array('id' => 'lat_id')), TRUE);
        field('select', 'currency', 'Currency:', NULL, array('options' => $currency, 'attribute' => array('id' => 'currency')), TRUE);
        field('select', 'rep_freg', 'Repayment Freg:', NULL, array('options' => $rep_peraid, 'attribute' => array('validated' => '1')), TRUE);
        field("text", "loan_amount", "Loan Amount:", NULL, array('attribute' => array('validated' => '1', 'class' => "numeric cal_ins_amount")), TRUE);
        field("text", "loan_amount_in_word", "Amo In Word:", NULL, array('attribute' => array('validated' => '1')), TRUE);


        field("text", "firstrepayment_date", "First Repayment:", NULL, array('attribute' => array('class' => 'txtdate')), TRUE);


        echo close_block();

// Others
        echo open_block('installmets', 'Installmets...');
//        
//        field("text", "lead_interest", "Lead interest:", NULL, array('attribute' => array('disabled' => 'disabled')));
//        field("text", "principal_start", "Principal Start:", NULL, array('attribute' => array('disabled' => 'disabled')));
//        field("text", "principal_frequency", "Principal Frequency:", NULL, array('attribute' => array('class' => "numeric")), TRUE);
        field("text", "num_installments", "Num Installments:", NULL, array('attribute' => array('class' => "numeric cal_ins_amount")), TRUE);
        field("text", "interest_rate", "Interest Rate:", NULL, array('attribute' => array('class' => "numeric cal_ins_amount", 'id' => 'interest_rate')), TRUE);
        field("text", "ins_amount", "Installment Amount:", NULL, array('attribute' => array('class' => "numeric cal_ins_amount")), TRUE);

        echo close_block();

        echo close_span();


// End span5
        echo '<div id="note"><sup class="require">*</sup> <span>All require</span></div>';
        echo '</div>';

        echo '<div id="btn_action" class="span10"><div class="modal-footer">';

        echo form_submit(array('name' => 'Save', 'class' => 'btn btn-success'), 'Confirm');
        echo anchor('loan/lists', 'Cancel', 'class="btn"');
        echo '</div></div>';
        ?>

    </div>

    <script>

        jQuery.noConflict();
        (function ($) {


            $(function () {

                $('#btn_action').addClass("disable_box");
                $('.numeric').numberOnly();
                var uri = [
                    $('[name="base_url"]').val(),
                    $('[name="segment1"]').val(),
                    $('[name="segment2"]').val(),
                    $('[name="segment3"]').val(),
                ];
                //=============Date input type============
                $(".txtdate").datepicker({
                    defaultDate: '-0y',
                    buttonText: "Choose",
                    dateFormat: "yy-mm-dd"
                });
                $('#search_customer_by_code').click(function () {

                    var account_number = $('#account_number').val();
                    if (account_number == "") {
                        alert("Account Number is required..!");
                        $("#account_number").focus();
                        $('#btn_action').addClass("disable_box");
                    } else {

                        $('.loader').addClass('icon-loader');
                        $.post(uri[0] + "loan/find_loan_by_loan_code",
                                {
                                    'account_number': account_number
                                },
                        function (data) {

                            //$('.btn').removeAttr('disabled');
                            $('.loader').removeClass('icon-loader');
                            $('.loader').addClass('icon-search');

//                            alert(data.result);
//                            alert(data.lao_code);return false;

                            if (data.result == 0) {
                                $('[name="cid"],[name="view_con_cid"],[name="displayname"],[name="con_dob"],[name="con_address"],[name="con_typ_title"]').html("");
                                alert("Account number not found, please try another Account.");
                                $("#con_cid").focus();
                                $('#btn_action').addClass("disable_box");
                                //                            resetForm('#form_loan');///=======Reset form data
                                $('#form_loan').each(function () {
                                    this.reset()
                                });
                            }
                            else {
//                                alert(data.loa_acc_id);
//                                return false;
                                if (data.loa_detail != "Pending") {
                                    $('[name="loa_info"]').html('<span class="error"><p>This Accoundt Number already approve and disbursment. Try another..!</p></span>');
                                    $('.acc_info_des').hide();
                                    $('#btn_action').addClass("disable_box");
                                    return false;

                                } else {
//                                    alert(data.loa_acc_id);
                                    $('.acc_info_des').show();
                                    $('[name="loa_info"]').html("");
                                    $('#btn_action').removeClass("disable_box"); //// =========Show botton submit========


                                    $('[name="con_id"]').val(data.con_id);
                                    $('[name="loa_id"]').val(data.loa_acc_id);

                                    $('[name="view_con_cid"]').html(data.con_cid);
                                    $('[name="displayname"]').html(data.con_en_last_name + " " + data.con_en_first_name);
                                    //                            $('[name="accountname"]').val(data.con_en_last_name+ " "+data.con_en_first_name);
                                    $('[name="con_dob"]').html(data.con_dob + " " + data.sex + "/" + data.civil);
                                    $('[name="con_address"]').html(data.con_address);
                                    $('#btn_action').removeClass("disable_box"); //// =========Show botton submit========

                                    $('[name="loa_con_id"]').val(data.loa_acc_id)
                                    $('[name="cid"]').html(data.con_id);
                                    $('[name="view_con_cid"]').html(data.con_cid);
                                    $('[name="displayname"]').html(data.con_en_last_name + " " + data.con_en_first_name);
                                    //                            $('[name="accountname"]').val(data.con_en_last_name+ " "+data.con_en_first_name);
                                    $('[name="con_dob"]').html(data.con_dob + " " + data.sex + "/" + data.civil);
                                    $('[name="con_address"]').html(data.con_address);

                                    // product datail
                                    $('[name="loa_acc_loa_pro_typ_id"]').val(data.pro_type);
                                    $('[name="co_id"]').val(data.co_id);
                                    $('[name="loa_sch_id"]').val(data.repayment_type);

                                    // Loan space
//                            $('[name="gl_code"]').val(data.gl);
                                    $('[name="won_type"]').val(data.loa_accc_ownership_type);
                                    $('[name="lat_id"]').val(data.loa_lat_id);
                                    $('[name="currency"]').val(data.currency);
                                    $('[name="loa_acc_amount_in_word"]').val(data.loa_acc_amount_in_word);
                                    $('[name="loan_amount"]').val(data.loa_amount);
                                    //                            $('[name="disbursment_date"]').val(data.loa_acc_disbustment);
                                    $('[name="rep_freg"]').val(data.loa_acc_rep_fre_id);
                                    $('[name="firstrepayment_date"]').val(data.loa_acc_first_repayment);
                                    //installment
                                    $('[name="num_installments"]').val(data.loa_ins_num_ins);
                                    $('[name="lead_interest"]').val(data.loa_ins_lead_interest);
                                    $('[name="principal_start"]').val(data.loa_ins_principal_start);
                                    $('[name="principal_frequency"]').val(data.loa_ins_principal_frequency);
                                    $('[name="interest_rate"]').val(data.loa_ins_interest_rate);
                                    $('[name="ins_amount"]').val(data.loa_ins_installment_amount);
                                }
                                return false;

                            }

                        },
                                'json'
                                );
                    }
                });
                $('.cal_ins_amount').change(function () {
                    console.log(num);
                    var num = $('[name="loan_amount"]').val();
                    var loan_amount = parseFloat(num.replace(/\s/g, "").replace(",", "")); // convert to number only
//                    alert(loan_amount);return;
                    var interest_rate = $('[name="interest_rate"]').val();
                    var num_installments = $('[name="num_installments"]').val();
                    $.post(uri[0] + "loan/calculate_interest",
                            {
                                'loan_amount': loan_amount,
                                'interest_rate': interest_rate,
                                'num_installments': num_installments
                            },
                    function (data) {
                        $('[name="ins_amount"]').val(data.instalment);
                    }, 'json');
                });
            });
        })(jQuery);


    </script>
</div>
<?php
echo form_close();
?>