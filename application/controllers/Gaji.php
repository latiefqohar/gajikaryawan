<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gaji extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'gaji/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'gaji/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'gaji/index.html';
            $config['first_url'] = base_url() . 'gaji/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Gaji_model->total_rows($q);
        $gaji = $this->Gaji_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'gaji_data' => $gaji,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'gaji/gaji_list',
            'judul' => 'Data Gaji Karyawan',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Gaji_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_gaji' => $row->id_gaji,
		'tgl' => $row->tgl,
		'nik' => $row->nik,
	    );
            $this->load->view('gaji/gaji_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gaji'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('gaji/create_action'),
	    'id_gaji' => set_value('id_gaji'),
	    'tgl' => set_value('tgl'),
	    'nik' => set_value('nik'),
        'konten' => 'gaji/gaji_form',
            'judul' => 'Data Gaji Karyawan',
    );
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tgl' => $this->input->post('tgl',TRUE),
		'nik' => $this->input->post('nik',TRUE),
	    );

            $this->Gaji_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('gaji'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Gaji_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('gaji/update_action'),
		'id_gaji' => set_value('id_gaji', $row->id_gaji),
		'tgl' => set_value('tgl', $row->tgl),
		'nik' => set_value('nik', $row->nik),
        'konten' => 'gaji/gaji_form',
            'judul' => 'Data Gaji Karyawan',
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gaji'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_gaji', TRUE));
        } else {
            $data = array(
		'tgl' => $this->input->post('tgl',TRUE),
		'nik' => $this->input->post('nik',TRUE),
	    );

            $this->Gaji_model->update($this->input->post('id_gaji', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('gaji'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Gaji_model->get_by_id($id);

        if ($row) {
            $this->Gaji_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('gaji'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gaji'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
	$this->form_validation->set_rules('nik', 'nik', 'trim|required');

	$this->form_validation->set_rules('id_gaji', 'id_gaji', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function send_mail(){
        $data=$this->db->query('select a.*,b.alamat,b.nama,b.email,c.pekerjaan,c.gapok,c.tukes,c.tutra,c.tupen,c.tukel from gaji a
        join karyawan b on a.nik=b.nik
        join pekerjaan c on b.id_pekerjaan=c.id_pekerjaan
        ')->result();
        foreach ($data as $row) {
            $kirim=array(
                'email'=>$row->email,
                'nik'=>$row->nik,
                'alamat'=>$row->alamat,
                'tgl'=>$row->tgl,
                'nama'=>$row->nama,
                'pekerjaan'=>$row->pekerjaan,
                'gapok'=>$row->gapok,
                'tukes'=>$row->tukes,
                'tutra'=>$row->tutra,
                'tupen'=>$row->tupen,
                'tukel'=>$row->tukel,
            );
            $this->mail($kirim);
        }

    }


    public function mail($kirim){

         $config = Array(   
            'protocol' => 'smtp',
           'smtp_host' => 'ssl://smtp.googlemail.com',
           'smtp_port' => 465,
           'smtp_user' => 'noreplyakunku@gmail.com',
           'smtp_pass' => 'noreplyakunku12',
           'mailtype'  => 'html', 
           'charset'   => 'iso-8859-1'    
          );
      
          $this->load->library('email', $config);
      
        $this->email->set_newline("\r\n");      
        $this->email->from('noreplyakunku@gmail.com', 'Pay Slip');
        $this->email->to($kirim['email']); // replace it with receiver mail id
        $this->email->subject('Pay Slip'); // replace it with relevant subject
        $total=$kirim["gapok"]+$kirim["tukes"]+$kirim["tutra"]+$kirim["tupen"]+$kirim["tukel"];
        $this->email->message('<html>

        <head>
        
          <meta charset="utf-8" />
        
          <title>Pay Slip</title>
        
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
            <style>
            h1{
                font-family: sans-serif;
                }
                
                table {
                font-family: Arial, Helvetica, sans-serif;
                color: #666;
                text-shadow: 1px 1px 0px #fff;
                background: #eaebec;
                border: #ccc 1px solid;
                }
                
                table th {
                padding: 15px 35px;
                border-left:1px solid #e0e0e0;
                border-bottom: 1px solid #e0e0e0;
                background: #ededed;
                }
                
                table th:first-child{  
                border-left:none;  
                }
                
                table tr {
                text-align: center;
                padding-left: 20px;
                }
                
                table td:first-child {
                text-align: left;
                padding-left: 20px;
                border-left: 0;
                }
                
                table td {
                padding: 15px 35px;
                border-top: 1px solid #ffffff;
                border-bottom: 1px solid #e0e0e0;
                border-left: 1px solid #e0e0e0;
                background: #fafafa;
                background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
                background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
                }
                
                table tr:last-child td {
                border-bottom: 0;
                }
                
                table tr:last-child td:first-child {
                -moz-border-radius-bottomleft: 3px;
                -webkit-border-bottom-left-radius: 3px;
                border-bottom-left-radius: 3px;
                }
                
                table tr:last-child td:last-child {
                -moz-border-radius-bottomright: 3px;
                -webkit-border-bottom-right-radius: 3px;
                border-bottom-right-radius: 3px;
                }
                
                table tr:hover td {
                background: #f2f2f2;
                background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
                background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
                }
            </style>
        </head>
        
        <body>
        
        <div>
        
          <div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header"><img style="border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 152px" src="<?= base_url(); ?>gambar/logo.png" alt="" width="152" height="108"></div>
        
        <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hallo ,'.$kirim['nama'].'</p>
        
        <p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> Terimakasih telah memberikan kontribusi selama sebulan penuh, Berikut kami cantumkan rincian gaji yang anda dapatkan </p>
        
        
        
        </div>
        
        <h3>Rincian gaji</h3>
        <table style="margin-bottom:50px">
        <thead>
                <tr>
                    <th>Nik</th>
                    <td>'.$kirim["nik"].'</td>
                    <th>Alamat</th>
                    <td>'.$kirim["alamat"].'</td>
                    <th>Tanggal</th>
                    <td>'.$kirim["tgl"].'</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Nama</th>
                    <td>'.$kirim["nama"].'</td>
                    <th>Jabatan</td>
                    <td>'.$kirim["pekerjaan"].'</td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KETERANGAN</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>Gaji Pokok</td>
                        <td>Rp. '.number_format($kirim["gapok"]).'</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Tunjangan Kesehatan</td>
                        <td>Rp. '.number_format($kirim["tukes"]).'</td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Tunjangan Transportasi</td>
                        <td>Rp. '.number_format($kirim["tutra"]).'</td>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td>Tunjangan Pendidikan</td>
                        <td>Rp. '.number_format($kirim["tupen"]).'</td>
                    </tr>
                    <tr>
                        <th>5</th>
                        <td>Tunjangan Keluarga</td>
                        <td>Rp. '.number_format($kirim["tukel"]).'</td>
                    </tr>
                    <tr>
                        <th colspan="2">TOTAL DITERIMA</th>
                        <th>Rp. '.number_format($total).'
                        </th>
                    </tr>
                </tbody>
            </table>
            <p>Note: Jika ada kesalahan dalam perhitungan gaji anda dapat menghubungi Payroll dengan membawa slip gaji anda</p>
        
        </body>
        
        </html>'); 
        if($this->email->send()){
            
            redirect('gaji','refresh');
            
      }else {
          echo 'gagal';
      } 
    }

}

/* End of file Gaji.php */
/* Location: ./application/controllers/Gaji.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-11-03 07:54:31 */
/* http://harviacode.com */