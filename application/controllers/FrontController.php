<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FrontController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['FrontModel', 'DataUserSekolahModel', 'AssetSekolahModel']);
	}

	// Untuk Halaman Home
	public function index()
	{
		$data['title'] = "Home";
		$data['start'] = $this->uri->segment(3);
		$data['getKepsek'] = $this->FrontModel->getKepsek()->row_array();
		$data['getWakilKepsek'] = $this->FrontModel->getWakilKepsek()->row_array();
		$data['getGuru'] = $this->FrontModel->getGuru()->result_array();
		$data['getJumlahGuru'] = $this->DataUserSekolahModel->getGuru()->num_rows();
		$data['getJumlahSiswa'] = $this->DataUserSekolahModel->getSiswa()->num_rows();
		$data['getNewInformasi'] = $this->AssetSekolahModel->getNewInformasi()->result_array();
		$data['getInformasi'] = $this->AssetSekolahModel->getDataInformasi()->result_array();
		$data['getInformasiOne'] = $this->AssetSekolahModel->getInformasiOne()->row_array();
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$data['getSiswa'] = $this->AssetSekolahModel->getSiswaBaru()->result_array();
		$data['open'] = $this->AssetSekolahModel->getstatus(1)->row_array();
		$data['pengumuman'] = $this->db->get('db_pengumuman')->row_array();
		// var_dump($data['open']);
		// die;
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/beranda', $data);
		$this->load->view('includes/Front/footer', $data);
	}

	// Untuk Validasi tambah data siswa baru
	public function storeSiswaBaruFront()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'required', ['required' => 'Nama Harus Di Isi']);
		$this->form_validation->set_rules('gender', 'Gender', 'required', ['required' => 'Jenis Kelamin Harus Di Isi']);
		$this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required', ['required' => 'Asal Sekolah Harus Di Isi']);
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required', ['required' => 'Tempat lahir Harus Di Isi']);

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Home";
			$data['start'] = $this->uri->segment(3);
			$data['getKepsek'] = $this->FrontModel->getKepsek()->row_array();
			$data['getWakilKepsek'] = $this->FrontModel->getWakilKepsek()->row_array();
			$data['getGuru'] = $this->FrontModel->getGuru()->result_array();
			$data['getJumlahGuru'] = $this->DataUserSekolahModel->getGuru()->num_rows();
			$data['getJumlahSiswa'] = $this->DataUserSekolahModel->getSiswa()->num_rows();
			$data['getNewInformasi'] = $this->AssetSekolahModel->getNewInformasi()->result_array();
			$data['getInformasi'] = $this->AssetSekolahModel->getDataInformasi()->result_array();
			$data['getInformasiOne'] = $this->AssetSekolahModel->getInformasiOne()->row_array();
			$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
			$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
			$this->load->view('includes/Front/header', $data);
			$this->load->view('pages/Front/beranda', $data);
			$this->load->view('includes/Front/footer', $data);
		} else {
			$this->AssetSekolahModel->storePendaftaranSiswa();
			$this->session->set_flashdata('status', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data Siswa baru</strong> Berhasil Di Tambah..
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>');
			redirect('FrontController/index');
		}
	}

	// Untuk Halaman Profile
	public function profile()
	{
		$data['title'] = "Profile";
		$data['start'] = $this->uri->segment(3);
		$data['getStrukturOrganisasi'] = $this->FrontModel->getStrukturOrganisasi()->row_array();
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getWhereVisi'] = $this->AssetSekolahModel->getWhereVisi()->result_array();
		$data['getWhereMisi'] = $this->AssetSekolahModel->getWhereMisi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$data['getProfile'] = $this->AssetSekolahModel->getProfile()->row_array();
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/profile', $data);
		$this->load->view('includes/Front/footer', $data);
	}

	// Untuk Halaman Guru
	public function guru()
	{
		$this->load->library('pagination');
		$this->db->from('db_guru');
		$config['total_rows'] = $this->db->count_all_results();
		$config['per_page'] = 6;

		// Pagination untuk Guru
		$config['base_url'] = 'http://localhost/app-pgs/FrontController/guru';

		// customes pagiantion
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center mt-3">';
		$config['full_tag_close'] = '</ul></nav>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = ['class' => 'page-link'];

		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);

		$data['title'] = "Guru";
		$data['getGuru'] = $this->DataUserSekolahModel->getPagination($config['per_page'], $data['start'])->result_array();
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/guru', $data);
		$this->load->view('includes/Front/footer', $data);
	}

	// Untuk Halaman Siswa
	public function siswa()
	{
		$data['title'] = "Siswa";
		$data['no'] = 1;
		$data['start'] = $this->uri->segment(3);
		$data['getSiswa'] = $this->DataUserSekolahModel->getSiswa()->result_array();
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/siswa', $data);
		$this->load->view('includes/Front/footer', $data);
	}

	// Untuk Halaman Ekskul
	public function kegiatan()
	{
		$data['title'] = "Kegiatan";
		$data['start'] = $this->uri->segment(3);
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$data['kegiatan'] = $this->AssetSekolahModel->getDataKegiatan()->result_array();
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/kegiatan');
		$this->load->view('includes/Front/footer', $data);
	}

	// Untuk Halaman Informasi
	public function informasi()
	{
		$data['title'] = "Informasi";
		$data['start'] = $this->uri->segment(3);
		$data['getInformasi'] = $this->AssetSekolahModel->getInformasi()->result_array();
		$data['getNewFooterInformasi'] = $this->AssetSekolahModel->getNewFooterInformasi()->result_array();
		$data['getSosialMedia'] = $this->FrontModel->getSosialMedia();
		$this->load->view('includes/Front/header', $data);
		$this->load->view('pages/Front/informasi', $data);
		$this->load->view('includes/Front/footer', $data);
	}
}
