<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AssetSekolahModel extends CI_Model
{
	// UNTUK DATA STRUKTUR ORGANISASI
	// Get Data Struktur Organisasi
	function getData()
	{
		return $this->db->get('struktur_organisasi');
	}

	// Store Data Organisasi Sekolah
	function store()
	{
		$file = $_FILES['struktur'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/struktur/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('struktur')) {
				$files = $this->upload->data('file_name', TRUE);
			} else {
				echo "error";
			}
		}
		$data = [
			'struktur' => $files
		];
		$this->db->insert('struktur_organisasi', $data);
	}

	// Update Data Struktur Organisasi
	function update()
	{
		$foto = $this->input->post('struktur');
		unlink(FCPATH . './assets/assetGambar/struktur/' . $foto);
		$this->db->where(['struktur' => $foto]);
		$this->db->delete('struktur_organisasi');
		$file = $_FILES['struktur'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/struktur/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('struktur')) {
				$files = $this->upload->data('file_name', TRUE);
			} else {
				echo "error";
			}
			$data = [
				'struktur' => $files
			];
			$this->db->insert('struktur_organisasi', $data);
		}
	}

	// Destroy Orfanisasi
	function destroyOrganisasi($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->delete('struktur_organisasi');
	}

	// UNTUK VISI DAN MISI
	// Get Data Visi & Misi
	function getVisiMisi()
	{
		return $this->db->get('db_visimisi');
	}

	// Get Visi
	function getWhereVisi()
	{
		$this->db->where(['jenis' => 'VISI']);
		return $this->db->get('db_visimisi');
	}

	// Get Misi
	function getWhereMisi()
	{
		$this->db->where(['jenis' => 'MISI']);
		return $this->db->get('db_visimisi');
	}

	// Store Data Visi & Misi
	function storeVisiMisi()
	{
		$data = [
			'isi' => $this->input->post('isi'),
			'jenis' => $this->input->post('jenis')
		];
		$this->db->set($data);
		$this->db->insert('db_visimisi');
	}

	// Update Data Visi Misi
	function updateVisiMisi($id)
	{
		$data = ['isi' => $this->input->post('updateisi')];
		$this->db->set($data);
		$this->db->where(['id' => $id]);
		$this->db->update('db_visimisi');
	}

	// Destroy Data Vsis Misi
	function destroyVisiMisi($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->delete('db_visimisi');
	}

	//  UNTUK PROFILE
	function getProfile()
	{
		return $this->db->get('db_profile');
	}

	// store profile
	public function storeProfile()
	{
		$data = [
			'isi_profile' => $this->input->post('store_profile'),
			'created_at' =>  time()
		];
		$this->db->set($data);
		$this->db->insert('db_profile');
	}

	// store profile
	public function updateProfile($id)
	{
		$data = [
			'isi_profile' => $this->input->post('update_Profile'),
		];
		$this->db->where('id', $id);
		$this->db->set($data);
		$this->db->update('db_profile');
	}

	// Destroy Profile
	function destroyProfile($id)
	{
		$this->db->where(['id' => $id]);
		$this->db->delete('db_profile');
	}


	// UNTUK DATA INFORMASI
	// Get Data Informasi Di Front End
	public function getInformasiOne()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Di Admin
	function getDataInformasi()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Di Admin
	function dataMoreInformasi($slug)
	{
		$this->db->where('slug_judul', $slug);
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Di Front End
	public function getInformasiDashboard()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(3);
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Di Front End
	public function getInformasi()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(6);
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Berdasarkan Berita Terbaru
	public function getNewInformasi()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(3);
		return $this->db->get('db_informasi');
	}

	// Get Data Informasi Berdasarkan Detail Informasi 
	public function getDetailInformasi($slug)
	{
		$this->db->where(['slug_judul' => $slug]);
		return $this->db->get('db_informasi');
	}

	// Get New Footer Data Informasi
	public function getNewFooterInformasi()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->limit(2);
		return $this->db->get('db_informasi');
	}

	// Store Data Informasi
	public function storeInformasi()
	{
		$file = $_FILES['foto'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png|jpeg';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/informasi/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('foto')) {
				$files = $this->upload->data('file_name', TRUE);
			} else {
				echo "error";
			}
		}
		$ouner = $this->db->get_where('userapp', ['email' => $this->session->userdata('email')])->row_array();
		$judul =  ucwords($this->input->post('judul'));
		$slug_judul = trim(strtolower($judul));
		$out = explode(" ", $slug_judul);
		$slug = implode("-", $out);
		$data = [
			'judul' => $judul,
			'isi' => $this->input->post('isi'),
			'foto' => $files,
			'ouner_post' => $ouner['nama'],
			'slug_judul' => $slug,
			'created_at' => time()
		];
		$this->db->insert('db_informasi', $data);
	}

	// Updata Data Informasi
	public function updateInformasi()
	{
		$file = $_FILES['foto'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/informasi/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('foto')) {
				$files = $this->upload->data('file_name', TRUE);
				$this->db->set(['foto' => $files]);
			} else {
				echo "error";
			}
		}
		$ouner = $this->db->get_where('userapp', ['email' => $this->session->userdata('email')])->row_array();
		$data = [
			'judul' => ucwords($this->input->post('judul')),
			'isi' => $this->input->post('isi'),
			'ouner_post' => $ouner['nama']
		];
		$this->db->where(['id' => $this->input->post('id')]);
		$this->db->set($data);
		$this->db->update('db_informasi');
	}

	// Destroy Data Informasi
	public function destroyInformasi($slug)
	{
		$foto = $this->db->get_where('db_informasi', ['slug_judul' => $slug])->row_array();
		unlink(FCPATH . './assets/assetGambar/informasi/' . $foto['foto']);
		$this->db->where(['slug_judul' => $slug]);
		$this->db->delete('db_informasi');
	}

	// SOSIAL MEDIA
	// Get Sosial Media
	function getSosialMedia()
	{
		return $this->db->get('db_sosial_media');
	}

	// Sore Sosial Media
	function storeSosialMedia()
	{
		$data = [
			'email' => $this->input->post('email'),
			'facebook' => $this->input->post('facebook'),
			'instagram' => $this->input->post('instagram'),
			'twitter' => $this->input->post('twitter'),
			'tik-tok' => $this->input->post('tik-tok'),
		];
		$this->db->set($data);
		$this->db->insert('db_sosial_media');
	}

	// Updata Sosial Meida
	function updateSosialMedia($id)
	{
		$data = [
			'email' => $this->input->post('email'),
			'facebook' => $this->input->post('facebook'),
			'instagram' => $this->input->post('instagram'),
			'twitter' => $this->input->post('twitter'),
			'tik-tok' => $this->input->post('tik-tok'),
		];
		$this->db->where(['id' => $id]);
		$this->db->set($data);
		$this->db->update('db_sosial_media');
	}

	// PENDAFTRAN SISWA BARU
	// get pendaftran SiswaBaru 
	function getSiswaBaru()
	{
		return $this->db->get('db_siswabaru');
	}

	// Store Siswa Baru
	function storePendaftaranSiswa()
	{
		$data = [
			'nama' => $this->input->post('nama', TRUE),
			'gender' => $this->input->post('gender', TRUE),
			'asal_sekolah' => $this->input->post('asal_sekolah', TRUE),
			'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
			'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
			'nik' => $this->input->post('nik', TRUE),
			'alamat' => $this->input->post('alamat', TRUE),
			'no_hp' => $this->input->post('no_hp', TRUE),
			'email' => $this->input->post('email', TRUE),
			'nama_ayah' => $this->input->post('nama_ayah', TRUE),
			'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah', TRUE),
			'nama_ibu' => $this->input->post('nama_ibu', TRUE),
			'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu', TRUE),
			'nilai_un' => $this->input->post('nilai_un', TRUE),
			'author' => $this->input->post('nama', TRUE)
		];
		$this->db->set($data);
		$this->db->insert('db_siswabaru');
	}

	// Store Siswa Baru
	function updatePendaftaranSiswa($id)
	{
		$data = [
			'nama' => $this->input->post('nama', TRUE),
			'gender' => $this->input->post('gender', TRUE),
			'asal_sekolah' => $this->input->post('asal_sekolah', TRUE),
			'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
			'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
			'nik' => $this->input->post('nik', TRUE),
			'alamat' => $this->input->post('alamat', TRUE),
			'no_hp' => $this->input->post('no_hp', TRUE),
			'email' => $this->input->post('email', TRUE),
		];
		$this->db->where('id', $id);
		$this->db->set($data);
		$this->db->update('db_siswabaru');
	}

	// Destroy data pendaftaran
	function destroyPendaftaranSiswa($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('db_siswabaru');
	}

	// Show pendaftran siswa baru
	function getShowSiswaBaru($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('db_siswabaru');
	}


	// KRGIATAN
	function getDataKegiatan()
	{
		return $this->db->get('db_kegiatan');
	}

	// Store kegitan
	function storeKegiatan()
	{
		$file = $_FILES['photo'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png|jpeg';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/kegiatan/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('photo')) {
				$files = $this->upload->data('file_name', TRUE);
			} else {
				echo "error";
			}
		}
		$judul =  ucwords($this->input->post('judul'));
		$slug_judul = trim(strtolower($judul));
		$out = explode(" ", $slug_judul);
		$slug = implode("-", $out);
		$data = [
			'judul' => $judul,
			'photo' => $files,
			'keterangan' => $this->input->post('isi'),
			'slug' => $slug,
			'created_at' => time()
		];
		$this->db->set($data);
		$this->db->insert('db_kegiatan');
	}

	// create kegiatan
	function createKegiatan($slug)
	{
		$this->db->where('slug', $slug);
		return $this->db->get('db_kegiatan');
	}

	// update kegatan
	function updateKegiatan($slug)
	{
		$file = $_FILES['photo'];
		if ($file) {
			$config['allowed_types']  = 'gif|jpg|png';
			$config['max_size']       = '2048';
			$config['upload_path']    = './assets/assetGambar/kegiatan/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('photo')) {
				$files = $this->upload->data('file_name', TRUE);
				$this->db->set('photo', $files);

				$foto = $this->db->get_where('db_kegiatan', ['slug' => $slug])->row_array();
				unlink(FCPATH . './assets/assetGambar/kegiatan/' . $foto['photo']);
			} else {
				echo "error";
			}
		}

		$judul =  ucwords($this->input->post('judul'));
		$slug_judul = trim(strtolower($judul));
		$out = explode(" ", $slug_judul);
		$slugid = implode("-", $out);

		$data = [
			'judul' => $this->input->post('judul'),
			'keterangan' => $this->input->post('kegiatan'),
			'slug' => $slugid,
		];
		$this->db->where('slug', $slug);
		$this->db->set($data);
		$this->db->update('db_kegiatan');
	}

	// Destroy kegaitan
	function destroyKegiatan($slug)
	{
		$foto = $this->db->get_where('db_kegiatan', ['slug' => $slug])->row_array();
		unlink(FCPATH . './assets/assetGambar/kegiatan/' . $foto['photo']);
		$this->db->where('slug', $slug);
		$this->db->delete('db_kegiatan');
	}


	public function getstatus($id)
	{
		$this->db->where(['id', $id]);
		return $this->db->get('open_pendaftaran');
	}
}
