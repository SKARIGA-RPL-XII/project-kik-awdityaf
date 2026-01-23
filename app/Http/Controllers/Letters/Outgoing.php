<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property Letter_Outgoing $letter_outgoing
 */
class Outgoing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Letter_Outgoing', 'letter_outgoing');
    }

    public function index()
    {
        $letterdate = getGet('letterdate');
        $letterstatus = getGet('letterstatus');
        $where = array();

        if ($letterdate != null) {
            $explode = explode(' - ', $letterdate);
            if (count($explode) == 2) {
                $start = date('Y-m-d', strtotime($explode[0]));
                $end = date('Y-m-d', strtotime($explode[1]));

                $where['a.letterdate >='] = $start;
                $where['a.letterdate <='] = $end;
            }
        } else {
            $where['a.letterdate'] = date('Y-m-d');
        }

        if ($letterstatus != null) {
            $where['a.letterstatus'] = $letterstatus;
        }
        $pending_where = [
            'is_tindak' => 0
        ];

        $count_pending = $this->letter_outgoing->total($pending_where);
        $data = array();
        $data['title'] = 'Arsip Surat Keluar';
        $data['content'] = 'archive/letters/outgoing/index';
        $data['letters'] = $this->letter_outgoing->order_by('a.letterdate', 'DESC')->result($where);
        $data['letterdate'] = $letterdate;
        $data['letterstatus'] = $letterstatus;
        $data['pendingCount'] = $count_pending;



        return $this->load->view('master', $data);
    }

    public function add()
    {
        $data = array();
        $data['title'] = 'Tambah Arsip Surat Keluar';
        $data['content'] = 'archive/letters/outgoing/add';

        return $this->load->view('master', $data);
    }

    public function add_process()
    {
        $letterfile = isset($_FILES['letterfile']) ? $_FILES['letterfile'] : null;
        $letterdate = getPost('letterdate');
        $letternumber = getPost('letternumber');
        $letterdestination = getPost('letterdestination');
        $lettersubject = getPost('lettersubject');
        $letterstatus = getPost('letterstatus');
        $letterdescription = getPost('letterdescription');

        $this->form_validation->set_rules('letterdate', 'Tanggal Surat', 'required|trim');
        $this->form_validation->set_rules('letternumber', 'Nomor Surat', 'required|trim');
        $this->form_validation->set_rules('letterdestination', 'Tujuan Surat', 'required|trim');
        $this->form_validation->set_rules('lettersubject', 'Perihal Surat', 'required|trim');
        $this->form_validation->set_rules('letterstatus', 'Status Surat', 'required|trim');
        $this->form_validation->set_rules('letterdescription', 'Keterangan Surat', 'trim');

        if ($this->form_validation->run() == false) {
            return JSONResponseDefault('FAILED', strip_tags(validation_errors()));
        }

        if ($letterfile['error'] == 0) {
            $config['upload_path'] = './uploads/letters/outgoing/';
            $config['allowed_types'] = 'pdf|xls|xlsx|xlsm|doc|docx';
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('letterfile')) {
                return JSONResponseDefault('FAILED', strip_tags($this->upload->display_errors()));
            }

            $data = array(
                'letterdate' => date('Y-m-d', strtotime($letterdate)),
                'letternumber' => $letternumber,
                'letterdestination' => $letterdestination,
                'lettersubject' => $lettersubject,
                'letterstatus' => $letterstatus,
                'letterdescription' => $letterdescription,
                'letterfile' => $this->upload->data('file_name'),
            );

            if ($this->letter_outgoing->insert($data)) {
                return JSONResponseDefault('OK', 'Berhasil menambah surat keluar');
            } else {
                return JSONResponseDefault('FAILED', 'Gagal menambah surat keluar');
            }
        } else {
            return JSONResponseDefault('FAILED', 'File surat tidak ditemukan');
        }
    }

    public function edit($id)
    {
        $letter = $this->letter_outgoing->row(array('id' => $id));
        if (!$letter) {
            return redirect(base_url('letters/outgoing'));
        }

        $data = array();
        $data['title'] = 'Ubah Arsip Surat Keluar';
        $data['content'] = 'archive/letters/outgoing/edit';
        $data['letter'] = $letter;

        return $this->load->view('master', $data);
    }

    public function edit_process($id)
    {
        $letter = $this->letter_outgoing->row(array('id' => $id));
        if (!$letter) {
            return JSONResponseDefault('FAILED', 'Data tidak ditemukan');
        }

        $letterfile = isset($_FILES['letterfile']) ? $_FILES['letterfile'] : null;
        $letterdate = getPost('letterdate');
        $letternumber = getPost('letternumber');
        $letterdestination = getPost('letterdestination');
        $lettersubject = getPost('lettersubject');
        $letterstatus = getPost('letterstatus');
        $letterdescription = getPost('letterdescription');
        $old_letterfile = getPost('old_letterfile');

        $this->form_validation->set_rules('letterdate', 'Tanggal Surat', 'required|trim');
        $this->form_validation->set_rules('letternumber', 'Nomor Surat', 'required|trim');
        $this->form_validation->set_rules('letterdestination', 'Tujuan Surat', 'required|trim');
        $this->form_validation->set_rules('lettersubject', 'Perihal Surat', 'required|trim');
        $this->form_validation->set_rules('letterstatus', 'Status Surat', 'required|trim');
        $this->form_validation->set_rules('letterdescription', 'Keterangan Surat', 'trim');

        if ($this->form_validation->run() == false) {
            return JSONResponseDefault('FAILED', strip_tags(validation_errors()));
        }

        if ($letterfile['error'] == 0) {
            $config['upload_path'] = './uploads/letters/outgoing/';
            $config['allowed_types'] = 'pdf|xls|xlsx|xlsm|doc|docx';
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('letterfile')) {
                return JSONResponseDefault('FAILED', strip_tags($this->upload->display_errors()));
            }

            if (file_exists('./uploads/letters/outgoing/' . $old_letterfile)) {
                @unlink('./uploads/letters/outgoing/' . $old_letterfile);
            }

            $data = array(
                'letterdate' => date('Y-m-d', strtotime($letterdate)),
                'letternumber' => $letternumber,
                'letterdestination' => $letterdestination,
                'lettersubject' => $lettersubject,
                'letterstatus' => $letterstatus,
                'letterdescription' => $letterdescription,
                'letterfile' => $this->upload->data('file_name'),
            );
        } else {
            $data = array(
                'letterdate' => date('Y-m-d', strtotime($letterdate)),
                'letternumber' => $letternumber,
                'letterdestination' => $letterdestination,
                'lettersubject' => $lettersubject,
                'letterstatus' => $letterstatus,
                'letterdescription' => $letterdescription,
            );
        }

        if ($this->letter_outgoing->update(array('id' => $id), $data)) {
            return JSONResponseDefault('OK', 'Berhasil mengubah surat keluar');
        } else {
            return JSONResponseDefault('FAILED', 'Gagal mengubah surat keluar');
        }
    }
    public function realis()
    {
        $id = getPost('id');
        $this->letter_outgoing->update(['id' => $id], ['is_realis' => 1]);
        return JSONResponseDefault('OK', 'Berhasil direalisasi');
    }



    public function tindak()
    {
        $id = getPost('id');
        $information = getPost('information') ?? 'Surat sudah ditindaklanjuti otomatis';

        $this->letter_outgoing->update(
            ['id' => $id],
            ['is_tindak' => 1, 'information' => $information]
        );
        return JSONResponseDefault('OK', 'Surat berhasil ditindaklanjuti');
    }


    public function delete()
    {
        $id = getPost('id');

        $this->form_validation->set_rules('id', 'ID Surat', 'required|trim');

        if ($this->form_validation->run() == false) {
            return JSONResponseDefault('FAILED', strip_tags(validation_errors()));
        }

        $letter = $this->letter_outgoing->row(array('id' => $id));
        if (!$letter) {
            return JSONResponseDefault('FAILED', 'Data tidak ditemukan');
        }

        if ($this->letter_outgoing->delete(array('id' => $id))) {
            if (file_exists('./uploads/letters/outgoing/' . $letter->letterfile)) {
                @unlink('./uploads/letters/outgoing/' . $letter->letterfile);
            }

            return JSONResponseDefault('OK', 'Data berhasil dihapus');
        } else {
            return JSONResponseDefault('FAILED', 'Data gagal dihapus');
        }
    }
}