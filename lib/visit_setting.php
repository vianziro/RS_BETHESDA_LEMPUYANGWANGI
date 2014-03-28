<?php
//update server = rm_inap.F01.php, rm_inap.F02.php, rm_inap.G02.php, rm_inap.C03.php, rm_inap.G03.php, rm_inap.H03.php

//Poli pakai rs00001 tt='LYN' 
$setting_poli = array (
		"igd"					=>"100",  //INSTALASI GAWAT DARURAT
		"umum"					=>"101",  //POLI UMUM
		"mata"					=>"102",  //POLI SPESIALIS MATA
		"peny_dalam"			=>"103",  //POLI SPESIALIS PENYAKIT DALAM
		"anak"					=>"104",  //POLI SPESIALIS PENYAKIT ANAK	
		"gigi"					=>"105",  //POLI GIGI
		"tht"					=>"106",  //POLI SPESIALIS THT
		"bedah"					=>"107",  //POLI SPESIALIS BEDAH
		"saraf"					=>"108",  //POLI SPESIALIS SARAF
		"kulit_kelamin"			=>"109",  //POLI SPESIALIS KULIT & KELAMIN
		"akupunktur"			=>"110",  //HEMODIALISA
		"gizi"					=>"111",  //POLI GIZI
		"jantung"				=>"112",  //POLI JANTUNG
		"paru"					=>"113",  //POLI PARU / ALERGI
		"kebidanan_obstetri"	=>"114",  //POLI KEBIDANAN & PENYAKIT KANDUNGAN / OBSTETERI (*)
		"kebidanan_ginekologi"	=>"115",  //POLI KEBIDANAN & PENYAKIT KANDUNGAN / GINEKOLOGI (*)
		"psikiatri"				=>"116",  //POLI PSIKIATRI
		"audiometri"			=>"117",  //POLI SPESIALIS AUDIOMETRI
		"pila_klinik"			=>"118",  //PILA KLINIK

		"kb"					=>"201",  //KELUARGA BERENCANA
		"apotek"				=>"202",  //APOTEK
		"laboratorium"			=>"203",  //LABORATORIUM
		"radiologi"				=>"204",  //RADIOLOGI
		"fisioterapi"			=>"205",  //FISIOTERAPI
		"kir_sekolah_kerja"		=>"206",  //KIR - SEKOLAH / PEKERJAAN
		"kir_ln_asuransi"		=>"207",  //KIR - LUAR NEGERI / ASURANSI
		"imunisasi"				=>"208",  //IMUNISASI	
		"operasi"				=>"209",  //IMUNISASI
		"pendperina"			=>"210"	//PERINATOLOGI
);

$setting_ri = array (
		"resume_dewasa_anak"						=>"A01",//@@@
		"resume_kebidanan"							=>"A02",//@@@
		"resume_bayi"								=>"A03",//@@@
		"grafik_suhu"								=>"B01",//@@@
		"grafik_ibu"								=>"B02",//@@@
		"grafik_bayi"								=>"B03",//@@@
		"ringkasan_masuk_keluar"					=>"C03",//@@@
		"dokumen_surat_pengantar"					=>"D04",//@@@ 
		"riwayat_penyakit_pemeriksaan_fisik"		=>"E05",//@@@
		"catatan_riwayat_kebidanan"					=>"F01",//@@@
		"catatan_bayi"								=>"F02",//@@@
		"catatan_harian_penyakit"					=>"F03",//@@@
		"catatan_perkembangan_bayi"					=>"F04",//@@@
		"laporan_anestesi"							=>"G01",//*####
		"laporan_pembedahan"						=>"G02",//@@@
		"laporan_pemakaian_alat"					=>"G03",//@@@
		"asuhan_keperawatan"						=>"H01",//@@@
		"proses_keperawatan"						=>"H02",//@@@
		"pemakaian_alat_keperawatan"				=>"H03",//@
		"pengawasan_pasien_dewasa"					=>"I01",//@@@
		"pengawasan_pasien_anak"					=>"I02",//@@@
		"catatan_obstetri"							=>"I03",//@@@
		"lembar_konsultasi"							=>"J10",//@@@
		"hasil_laboratorium"						=>"K01",//@@@
		"hasil_radiologi"							=>"K02",//@@@
		"hasil_EKG"									=>"K03",//@@@
		"hasil_USG"									=>"K04",//@@@	
);

		
$visit_jantung = array (
		"vis_1"=>"Keluhan Utama "   						, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu "  				, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Sekarang "				, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Faktor Resiko " 							, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Kesadaran " ,"vis_6"=>"Tensi " ,"vis_7"=>"Nadi ","vis_8"=>"Respirasi "	, "vis_5F"=>"edit4","vis_5W"=>10,
		"vis_9"=>"Kulit     "	,"vis_10"=>"Berat Badan   ","vis_11"=>"Suhu ","vis_12"=>"Lain-Lain "	, "vis_9F"=>"edit5","vis_9W"=>10,
		"vis_13"=>"DD" 										, "vis_13F"=>"memo1","vis_13W"=>50,
		"vis_14"=>"Lain-Lain " 								, "vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Diagnosa " 								, "vis_15F"=>"memo","vis_15W"=>50,
		);

$visit_pendperina = array (
		"vis_2"=>"Partus " 									, "vis_2F"=>"edit","vis_2W"=>10, "vis_3F"=>"edit","vis_3W"=>10,
		"vis_3"=>"Anak Ke " 								, "vis_3F"=>"edit","vis_3W"=>10,
		"vis_4"=>"Perkawinan Ke " 							, "vis_4F"=>"edit","vis_4W"=>10,
		
		"vis_8"=>"Riwayat Kesehatan Ayah " 							, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"Riwayat Kesehatan Ibu " 							, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"Riwayat Kesehatan Keluarga " 					, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"Berat Badan " 							, "vis_11F"=>"berat","vis_11W"=>10,
		"vis_12"=>"Tinggi Badan " 							, "vis_12F"=>"tinggi","vis_12W"=>10,
		"vis_13"=>"Anamnesa " 						, "vis_13F"=>"memo","vis_13W"=>50,
		"vis_14"=>"Laborat Mantoux ",
"vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Diagnosa " 								, "vis_15F"=>"memo","vis_15W"=>50,
		);

$visit_penyakit_dalam = array (
		"vis_1"=>"Keluhan Utama "   						, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu "  				, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Sekarang "				, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Faktor Resiko " 							, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Kesadaran " ,"vis_6"=>"Tensi " ,"vis_7"=>"Nadi ","vis_8"=>"Respirasi "	, "vis_5F"=>"edit4","vis_5W"=>10,
		"vis_9"=>"Kulit     "	,"vis_10"=>"Berat Badan   ","vis_11"=>"Suhu ","vis_12"=>"Lain-Lain "	, "vis_9F"=>"edit5","vis_9W"=>10,
		"vis_13"=>"DD" 										, "vis_13F"=>"memo1","vis_13W"=>50,
		"vis_14"=>"Lain-Lain " 								, "vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Diagnosa " 								, "vis_15F"=>"memo","vis_15W"=>50,
		);
//febri 26112012		
$visit_anak = array (
		"vis_1"=>"Berat Waktu Lahir "						, "vis_1F"=>"berat","vis_1W"=>10,
		"vis_2"=>"Riwayat Persalinan " 									, "vis_2F"=>"edit","vis_2W"=>10,
		"vis_3"=>"Anak Ke " 								, "vis_3F"=>"edit","vis_3W"=>10,
		"vis_4"=>"Perkawinan Ke " 							, "vis_4F"=>"edit","vis_4W"=>10,
		//"vis_5"=>"Anak Pungut Sejak " 						, "vis_5F"=>"textinfo","vis_5W"=>10,
		"vis_6"=>"Penyakit Yang Sudah Dialami " 			, "vis_6F"=>"memo","vis_6W"=>50,
		//"vis_7"=>"Tanggal Penyakit " 						, "vis_7F"=>"textinfo","vis_7W"=>10,
		"vis_8"=>"Kesehatan Ayah " 							, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"Kesehatan Ibu " 							, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"Kesehatan Keluarga " 					, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"Berat Badan " 							, "vis_11F"=>"berat","vis_11W"=>10,
		"vis_12"=>"Tinggi Badan " 							, "vis_12F"=>"tinggi","vis_12W"=>10,
		"vis_13"=>"Laborat Mantoux " 						, "vis_13F"=>"memo","vis_13W"=>50,
		"vis_14"=>"Diagnosa " 								, "vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Keluahan Utama " 						,"vis_15W"=>50,
		);	
		
$visit_bedah=array(
		"vis_1"=>"Keluhan Utama "   						, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu "  						, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Sekarang "						, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Faktor Resiko " 							, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Kesadaran " ,"vis_6"=>"Tensi " ,"vis_7"=>"Nadi ","vis_8"=>"Respirasi "	, "vis_5F"=>"edit4","vis_5W"=>10,
		"vis_9"=>"Kulit     "	,"vis_10"=>"Berat Badan   ","vis_11"=>"Suhu ","vis_12"=>"Lain-Lain "	, "vis_9F"=>"edit5","vis_9W"=>10,
		"vis_13"=>"DD" 										, "vis_13F"=>"memo1","vis_13W"=>50,
		"vis_14"=>"Lain-Lain " 								, "vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Laboratorium"							, "vis_15F"=>"memo","vis_15W"=>50,
		"vis_16"=>"Keterangan " 							, "vis_16F"=>"edit","vis_16W"=>50,
		"vis_17"=>"API " 									, "vis_17F"=>"memo","vis_17W"=>50,
		"vis_18"=>"Dikametosa " 							, "vis_18F"=>"memo","vis_18W"=>50,
		"vis_19"=>"Alternatif " 							, "vis_19F"=>"memo","vis_19W"=>50,
		"vis_20"=>"Diagnosa " 								, "vis_20F"=>"memo","vis_20W"=>50,
		);
//febri 26112012		
$visit_kulit_kelamin = array (
		"vis_1"=>"Anamnesa "   								, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Sekarang "  				, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Dahulu "  				, "vis_3F"=>"memo","vis_3W"=>50, 
		"vis_4"=>"Riwayat Penyakit Keluarga "  				, "vis_4F"=>"memo","vis_4W"=>50, 
		"vis_5"=>"Riwayat Penyakit Lain-Lain "  			, "vis_5F"=>"memo","vis_5W"=>50, 
		"vis_6"=>"Kesadaran " ,"vis_7"=>"Tensi " ,"vis_8"=>"Nadi ","vis_9"=>"suhu ", "vis_6F"=>"edit4","vis_6W"=>20,
		"vis_10"=>"Kulit","vis_11"=>"Tinggi Badan ","vis_14"=>"Berat Badan","vis_15"=>"Pernafasan ", "vis_10F"=>"edit5","vis_10W"=>20,
		"vis_12"=>"Keadaan Umum "							, "vis_12F"=>"check1","vis_12W"=>50,
		"vis_13"=>"Keadaan Gizi"							, "vis_13F"=>"check2","vis_13W"=>50,
		"vis_16"=>"Lokasi " 								, "vis_16F"=>"edit1","vis_16W"=>50,
		"vis_17"=>"Effloresensi " 							, "vis_17F"=>"edit1","vis_17W"=>50,
		"vis_18"=>"Diagnosa" 								, "vis_18F"=>"memo1","vis_18W"=>50,
		"vis_19"=>"Pengobatan Sementara" 					, "vis_19F"=>"memo1","vis_19W"=>50,
		"vis_20"=>"Rencana Pengobatan" 						, "vis_20F"=>"memo1","vis_20W"=>50,
		"vis_21"=>"Keluhan Utama" 							, "vis_21W"=>50,
);

		
$visit_gigi = array (
		"vis_1"=>"Nomenklatur Gigi"   						, "vis_1F"=>"edit1","vis_1W"=>20,
		"vis_6"=>"Nomenklatur Gigi SUSU"   						, "vis_6F"=>"edit3","vis_6W"=>20,

		"vis_2"=>"Odontogram "  							, "vis_2F"=>"edit2","vis_2W"=>20,
		"vis_7"=>"Odontogram Gigi Susu"   						, "vis_7F"=>"edit4","vis_7W"=>20,
 
 
		"vis_3"=>"Anamnesa "								, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Pemeriksaan Lain"							, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Diagnosa "								, "vis_5F"=>"memo","vis_5W"=>50,
		"vis_8"=>"Keluhan Utama "							, "vis_8W"=>50,
);
//febri 26112012
$visit_akupunktur = array (
		"vis_1"=>"Keluhan Utama "   						, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu "  						, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Sekarang "						, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Faktor Resiko " 							, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Kesadaran " ,"vis_6"=>"Tensi " ,"vis_7"=>"Nadi ","vis_8"=>"Respirasi "	, "vis_5F"=>"edit4","vis_5W"=>10,
		"vis_9"=>"Kulit     "	,"vis_10"=>"Berat Badan   ","vis_11"=>"Suhu ","vis_12"=>"Lain-Lain "	, "vis_9F"=>"edit5","vis_9W"=>10,
		"vis_13"=>"DD" 										, "vis_13F"=>"memo1","vis_13W"=>50,
		"vis_14"=>"Lain-Lain " 								, "vis_14F"=>"memo2","vis_14W"=>50,
		"vis_15"=>"Diagnosa " 								, "vis_15F"=>"memo3","vis_15W"=>50,
		);
		
$visit_umum = array (
		"vis_1"=>"Anamnesa"   								, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Kesadaran " ,"vis_3"=>"Tensi " ,"vis_4"=>"Nadi ","vis_5"=>"Respirasi "	, "vis_2F"=>"edit4","vis_2W"=>10,
		"vis_6"=>"Kulit     "	,"vis_7"=>"Berat Badan   ","vis_8"=>"Suhu ","vis_9"=>"Lain-Lain "	, "vis_5F"=>"edit5","vis_5W"=>10,
		"vis_10"=>"Pemeriksaan Lain"							, "vis_10F"=>"memo","vis_10W"=>50,
		"vis_11"=>"Diagnosa "								, "vis_11F"=>"memo1","vis_11W"=>50,
		"vis_12"=>"Keadaan Umum" ,
		"vis_12"=>"Keluhan Utama" 							,"vis_12W"=>50,
);
//febri 26112012
$visit_fisioterapi = array (
		"vis_1"=>"Anamnesa  "   					, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Pemeriksaan "  					, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Diagnosa "						, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Program Fisioterapi " 			, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Pengobatan " 						, "vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"FT " 								, "vis_6F"=>"memo","vis_6W"=>50,
		"vis_7"=>"Psikologi " 						, "vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"Social Medic " 					, "vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"Speech Therapy " 					, "vis_9F"=>"memo","vis_9W"=>50,
		"vis_10"=>"OT " 							, "vis_10F"=>"memo","vis_10W"=>50,

		"vis_11"=>"Anamnesa  "   					, "vis_11F"=>"memo","vis_11W"=>50,
		"vis_12"=>"Pemeriksaan "  					, "vis_12F"=>"memo","vis_12W"=>50, 
		"vis_13"=>"Diagnosa "						, "vis_13F"=>"memo","vis_13W"=>50,
		"vis_14"=>"Program Fisioterapi " 			, "vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Pengobatan " 					, "vis_15F"=>"memo","vis_15W"=>50,
		"vis_16"=>"FT " 							, "vis_16F"=>"memo","vis_16W"=>50,
		"vis_17"=>"OP " 							, "vis_17F"=>"memo","vis_17W"=>50,
		
		"vis_18"=>"Anamnesa  "   					, "vis_18F"=>"memo","vis_18W"=>50,
		"vis_19"=>"Pemeriksaan "  					, "vis_19F"=>"memo","vis_19W"=>50, 
		"vis_20"=>"Diagnosa "						, "vis_20F"=>"memo","vis_20W"=>50,
		"vis_21"=>"Program Fisioterapi " 			, "vis_21F"=>"memo","vis_21W"=>50,
		"vis_22"=>"Pengobatan " 					, "vis_22F"=>"memo","vis_22W"=>50,
		"vis_23"=>"OT " 							, "vis_23F"=>"memo","vis_23W"=>50,
    
        "vis_24"=>"Anamnesa  "   					, "vis_24F"=>"memo","vis_24W"=>50,
		"vis_25"=>"Pemeriksaan "  					, "vis_25F"=>"memo","vis_25W"=>50, 
		"vis_26"=>"Diagnosa "						, "vis_26F"=>"memo","vis_26W"=>50,
		"vis_27"=>"Program Fisioterapi " 			, "vis_27F"=>"memo","vis_27W"=>50,
		"vis_28"=>"Pengobatan " 					, "vis_28F"=>"memo","vis_28W"=>50,
		"vis_29"=>"Speech Therapy" 					, "vis_29F"=>"memo","vis_29W"=>50,
  
    
        "vis_30"=>"Anamnesa  "   					, "vis_30F"=>"memo","vis_30W"=>50,
		"vis_31"=>"Pemeriksaan "  					, "vis_31F"=>"memo","vis_31W"=>50, 
		"vis_32"=>"Diagnosa "						, "vis_32F"=>"memo","vis_32W"=>50,
		"vis_33"=>"Program Fisioterapi " 			, "vis_33F"=>"memo","vis_33W"=>50,
		"vis_34"=>"Pengobatan " 					, "vis_34F"=>"memo","vis_34W"=>50,
		"vis_35"=>"OP " 							, "vis_35F"=>"memo","vis_35W"=>50,
    
    
    
    
);
$visit_operasi = array (
		"vis_1"=>"Waktu Operasi  "   				, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Jenis Diagnosa "  				, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Tindakan Operasi "				, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Jenis Operasi " 					, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Jenis Anastesi " 					, "vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Diagnosa Prabedah " 				, "vis_6F"=>"memo","vis_6W"=>50,
        "vis_7"=>"Indikasi " 						, "vis_7F"=>"memo","vis_7W"=>50,
        "vis_8"=>"Nama Operasi " 					, "vis_8F"=>"memo","vis_8W"=>50,
        "vis_9"=>"Diagnosa Post Operasi " 			, "vis_9F"=>"memo","vis_9W"=>50,
        "vis_10"=>"Jaringan yang diinsisi" 			, "vis_10F"=>"memo","vis_10W"=>50,
);

//febri 26112012
$visit_igd = array (
		"vis_1"=>"Dikirim Oleh"   							, "vis_1F"=>"edit","vis_1W"=>40,
		"vis_2"=>"Diantar Oleh"  							, "vis_2F"=>"edit","vis_2W"=>40, 
		"vis_3"=>"Tanggal Kejadian"							, "vis_3F"=>"textinfo","vis_3W"=>10,
		"vis_4"=>"Waktu Kejadian" 							, "vis_4F"=>"textinfo1","vis_4W"=>10,
		"vis_5"=>"Tempat Kejadian " 						, "vis_5F"=>"edit","vis_5W"=>40,
		"vis_6"=>"Dokter Jaga" 								, "vis_6F"=>"edit","vis_6W"=>40,
		"vis_7"=>"Perawat Unit Darurat" 					, "vis_7F"=>"edit","vis_7W"=>40,
		"vis_8"=>"Tanggal Kedatangan " 						, "vis_8F"=>"textinfo2","vis_8W"=>10,
		"vis_9"=>"Waktu Kedatangan " 						, "vis_9F"=>"textinfo3","vis_9W"=>10,
		"vis_10"=>"Kasus Polisi " 							, "vis_10F"=>"check1","vis_10W"=>50,
		"vis_11"=>"Pasien " 								, "vis_11F"=>"check2","vis_11W"=>50,
		"vis_12"=>"Riwayat Kejadian" 						, "vis_12F"=>"memo","vis_12W"=>48,
		"vis_13"=>"Umum Tensi" ,"vis_14"=>"Nadi" ,"vis_15"=>"Suhu","vis_16"=>"Pernafasan"	, "vis_13F"=>"edit4","vis_13W"=>10,
		"vis_17"=>"Keadaan Umum" 							, "vis_17F"=>"check3","vis_17W"=>50,
		"vis_18"=>"Kesadaran" 								, "vis_18F"=>"edit","vis_18W"=>30,
		"vis_19"=>"Lain-Lain" 								, "vis_19F"=>"edit","vis_19W"=>30,
		"vis_20"=>"Kepala dan Muka" 						, "vis_20F"=>"edit3","vis_20W"=>50,
		"vis_21"=>"Luka" 									, "vis_21F"=>"edit3","vis_21W"=>50,
		"vis_22"=>"Leher" 									, "vis_22F"=>"edit3","vis_22W"=>50,
		"vis_23"=>"Tulang Belakang" 						, "vis_23F"=>"edit3","vis_23W"=>50,
		"vis_24"=>"Pelvis" 									, "vis_24F"=>"edit3","vis_24W"=>50,
		"vis_25"=>"Dada" 									, "vis_25F"=>"edit3","vis_25W"=>50,
		"vis_26"=>"Perut" 									, "vis_26F"=>"edit3","vis_26W"=>50,
		"vis_27"=>"Bagian Bawah " 							, "vis_27F"=>"edit2","vis_27W"=>50,
		"vis_28"=>"Bagian Bawah Kanan " 					, "vis_28F"=>"edit2","vis_28W"=>50,
		"vis_29"=>"Bagian Bawah Kiri " 						, "vis_29F"=>"edit2","vis_29W"=>50,
		"vis_30"=>"Bagian Atas " 							, "vis_30F"=>"edit2","vis_30W"=>50,
		"vis_31"=>"Bagian Atas Kanan " 						, "vis_31F"=>"edit2","vis_31W"=>50,
		"vis_32"=>"Bagian Atas Kiri " 						, "vis_32F"=>"edit2","vis_32W"=>50,
		"vis_33"=>"Buka Mata " 			, "vis_33F"=>"edit2","vis_33W"=>50,
		"vis_34"=>"Respon Motor " 		, "vis_34F"=>"edit2","vis_34W"=>50,
		"vis_35"=>"Respons Verbal " 		, "vis_35F"=>"edit2","vis_35W"=>50,
		"vis_36"=>"Diagnosa "  								, "vis_36F"=>"memo1","vis_36W"=>50,
		"vis_37"=>"Berat Badan "  						,
);
//febri 26112012		

$visit_laboratorium = array (
		"vis_1"=>"Catatan Laboratorium"   					, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Diagnosa " 								, "vis_2F"=>"memo1","vis_2W"=>50,
		"vis_3"=>"Hasil Pemeriksaan " 					, "vis_3F"=>"memo1","vis_3W"=>50,
);

$visit_radiologi = array (
		"vis_1"=>"Jenis Pemeriksaan"		   					, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Diagnosa " 								, "vis_2F"=>"memo1","vis_2W"=>50,
		"vis_3"=>"No Foto" 								, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Tanggal" 								, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Ruang" 								, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Dokter Pengirim" 								, "vis_6F"=>"memo1","vis_6W"=>50,
		"vis_7"=>"Hasil Bacaan" 								, "vis_7F"=>"memo1","vis_7W"=>50,
		"vis_8"=>"Radiolog" 								, "vis_8F"=>"memo1","vis_8W"=>50,
		"vis_9"=>"35 x 35 cm" 								, "vis_9F"=>"edit","vis_9W"=>10,
		"vis_10"=>"30 X 40 cm" 								, "vis_10F"=>"edit","vis_10W"=>10,
		"vis_11"=>"24 x 30 cm" 								, "vis_11F"=>"edit","vis_11W"=>10,
		"vis_12"=>"18 x 24 cm" 								, "vis_12F"=>"edit","vis_12W"=>10,
		"vis_13"=>"13 x 18 cm" 								, "vis_13F"=>"edit","vis_13W"=>10,
		"vis_14"=>"3 x 5 cm" 								, "vis_14F"=>"edit","vis_14W"=>10,
		"vis_15"=>"Film USG" 								, "vis_15F"=>"edit","vis_15W"=>10,
		"vis_16"=>"Film CT" 								, "vis_16F"=>"edit","vis_16W"=>10,
		"vis_17"=>"Tepung" 								, "vis_17F"=>"edit","vis_18W"=>10,
		"vis_18"=>"Botol" 								, "vis_18F"=>"edit","vis_18W"=>10,
		// di bawah = USG di radiologi
		"vis_22"=>"Hepar" 								, "vis_22F"=>"edit","vis_22W"=>50,
		"vis_23"=>"Vesica Fellea" 						, "vis_23F"=>"edit","vis_23W"=>50,
		"vis_24"=>"Pancreas" 							, "vis_24F"=>"edit","vis_24W"=>50,
		"vis_25"=>"Lien" 								, "vis_25F"=>"edit","vis_25W"=>50,
		"vis_26"=>"Renal Kanan dan Kiri" 				, "vis_26F"=>"edit","vis_26W"=>50,
		"vis_27"=>"Vesica Urinaria" 					, "vis_27F"=>"edit","vis_27W"=>50,
);

//febri 26112012
$visit_tht = array (
		"vis_1"=>"Anamnesa"									, "vis_1F"=>"memo","vis_1W"=>48,
		"vis_2"=>"Anamnesa / Keluarga"						, "vis_2F"=>"memo","vis_2W"=>48,
		"vis_3"=>"Alergi Diathesa Haemorachi"				, "vis_3F"=>"memo","vis_3W"=>48,
		"vis_4"=>"Hal-Hal Yang Penting"						, "vis_4F"=>"memo","vis_4W"=>48,
		"vis_5"=>"Uvula " ,"vis_6"=>"Plat.Molle/dur " ,"vis_7"=>"Tonsilac ","vis_8"=>"Arc Palatoglos ","vis_9"=>"Arc Palatotophar ", "vis_6F"=>"edit","vis_6W"=>20,
		"vis_10"=>"Sel Lendir " ,"vis_11"=>"Choanae/Vomer" ,"vis_12"=>"Muara Tuba", "vis_10F"=>"edit2","vis_10W"=>20,
		"vis_13"=>"Epiglottis " ,"vis_14"=>"Plica VOC" ,"vis_15"=>"Arythenoid", "vis_13F"=>"edit3","vis_13W"=>20,
		"vis_16"=>"HB"										, "vis_16F"=>"edit1","vis_16W"=>50,
		"vis_17"=>"Masa Pendarahan"							, "vis_17F"=>"edit1","vis_17W"=>50,
		"vis_18"=>"Masa Pembekuan"	 						, "vis_18F"=>"edit1","vis_18W"=>50,
		"vis_19"=>"Leocosit"								, "vis_19F"=>"edit1","vis_19W"=>50,
		"vis_20"=>"Terapi / Obat-Obatan"					, "vis_20F"=>"edit1","vis_20W"=>50,
		"vis_21"=>"Rencana Pemeriksaan"						, "vis_21F"=>"edit1","vis_21W"=>50,
		"vis_22"=>"Konsul"									, "vis_22F"=>"edit1","vis_22W"=>50,
		"vis_23"=>"Dirawat / Tgl"							, "vis_23F"=>"edit1","vis_23W"=>20,
		"vis_24"=>"Diagnosa"								, "vis_24F"=>"edit1","vis_24W"=>50,
		"vis_25"=>"Keluhan Utama"							, "vis_25W"=>48,
		);
		
$visit_paru = array (
		"vis_1"=>"Keluhan Utama "   						, "vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu "  						, "vis_2F"=>"memo","vis_2W"=>50, 
		"vis_3"=>"Riwayat Penyakit Sekarang "						, "vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Keadaan Umum" ,
		"vis_5"=>"Berat Badan" ,
		"vis_6"=>"Tensi",
		"vis_7"=>"Nadi",
		"vis_8"=>"Suhu"													,"vis_4F"=>"edit5","vis_4W"=>10,
		"vis_9"=>"HB" ,
		"vis_10"=>"Leucosit" ,
		"vis_11"=>"L.E.D",
		"vis_12"=>"Diff",												"vis_9F"=>"edit4","vis_9W"=>20,
		"vis_13"=>"Liver Fungsi Test ",
		"vis_14"=>"Gula Darah" ,
		"vis_15"=>"N" ,
		"vis_16"=>"P.P"													, "vis_14F"=>"edit3","vis_14W"=>20,
		"vis_17"=>"Urine" ,
		"vis_18"=>"Red" ,
		"vis_19"=>"Prot",
		"vis_20"=>"Sedimen"												,"vis_17F"=>"edit_4","vis_17W"=>20,
		"vis_21"=>"Spuntum"											, "vis_21F"=>"check","vis_21W"=>10,
		"vis_22"=>"Lain-Lain" 										, "vis_22F"=>"edit2","vis_22W"=>50,
		"vis_23"=>"Mantouk Test" 									, "vis_23F"=>"memo2","vis_23W"=>50,
		"vis_24"=>"Radiologi" 									, "vis_24F"=>"memo2","vis_24W"=>50,
		"vis_25"=>"Terapi" 									, "vis_25F"=>"memo2","vis_25W"=>50,
		"vis_26"=>"Saran / Rencana" 						, "vis_26F"=>"memo2","vis_26W"=>50,
		"vis_27"=>"Diagnosa " 								, "vis_27F"=>"memo1","vis_27W"=>50,
		
		);
//febri 26112012
$visit_mata = array (
		"vis_1"=>"Anamnesa"   								, "vis_1F"=>"memo","vis_1W"=>69,
		"vis_2"=>"Dikirim Oleh"  							, "vis_2F"=>"edit","vis_2W"=>30,
		"vis_3"=>"Palpebra OD ","vis_4"=>"Palpebra OS " ,"vis_5"=>"Conjunctiva OD ","vis_6"=>"Conjunctiva OS ",
		"vis_7"=>"Cornea OD " ,"vis_8"=>"Cornea OS ","vis_9"=>"C.O.A OD " ,"vis_10"=>"C.O.A OS ",
		"vis_11"=>"Iris OD ","vis_12"=>"Iris OS " ,"vis_13"=>"Pupil OD ","vis_14"=>"Pupil OS ",
		"vis_15"=>"Lensa OD " ,"vis_16"=>"Lensa OS ","vis_17"=>"Vitreous OD " ,"vis_18"=>"Vitreous OS ",	
		"vis_19"=>"Humor OD " ,"vis_20"=>"Humor OS ","vis_21"=>"Punduskopi OD " ,"vis_22"=>"Punduskopi OS ",
		"vis_23" =>"Visus OD","vis_24"=>"Visus OS","vis_25"=>"Koreksi OD","vis_26"=>"Koreksi OS",
		"vis_27" =>"Kacamata Lama OD","vis_28"=>"Kacamata Lama OS","vis_29"=>"Aplansi OD","vis_30"=>"Aplansi OS",
		"vis_31"=>"Tonometri OD","vis_32"=>"Tonometri OS","vis_33"=>"Anel OD","vis_34"=>"Anel OS","vis_3F"=>"edit1","vis_3W"=>30,
		"vis_35"=>"Baca" 									, "vis_35F"=>"edit","vis_35W"=>50,
		"vis_36"=>"Steak Retinoskopi/Keratome/Skiasko" 		, "vis_36F"=>"memo","vis_36W"=>55,
		"vis_39"=>"Laboratorium" 							, "vis_39F"=>"memo","vis_39W"=>55,
		"vis_40"=>"Sistem Lacrimal" 						, "vis_40F"=>"memo","vis_40W"=>55,
		"vis_41"=>"Diagnosa" 								, "vis_41F"=>"memo","vis_41W"=>55,
		"vis_42"=>"Keterangan OD" 							, "vis_42F"=>"edit1","vis_42W"=>55,
		"vis_43"=>"Keterangan OS" 							, "vis_43F"=>"edit1","vis_43W"=>55,
		"vis_44"=>"Keluhan Utama" 							, "vis_44W"=>69,
);

//klinik kebidanan_ginekologi -> penyakit kewanitaan
$visit_ginekologi = array(
	//Pemeriksaan umum
		"vis_1"=>"Keadaan Umum" ,"vis_2"=>"Tinggi Badan" ,"vis_3"=>"Tekanan Darah","vis_4"=>"Suhu"	, 
		"vis_5"=>"Jantung"	,"vis_6"=>"Berat Badan   ","vis_7"=>"Paru-paru","vis_8"=>"Nadi"	, "vis_5F"=>"edit8","vis_5W"=>15,
		//checkbox
		"vis_9"=>"Hepatomegali", "vis_10"=>"Edema-Tungkai"					, "vis_9F"=>"check1","vis_7W"=>30,
		"vis_11"=>"Splenomegali", "vis_12"=>"Asites"						, "vis_11F"=>"check2","vis_7W"=>30,
		"vis_13"=>"Hidronefrosis", "vis_14"=>"Hidrotoraks"					, "vis_13F"=>"check3","vis_7W"=>30,
		//Pembesaran kelenjar Getah bening
		"vis_15"=>"","vis_16"=>"","vis_17"=>"","vis_18"=>"","vis_19"=>"","vis_20"=>"","vis_21"=>"","vis_22"=>"","vis_23"=>"", "vis_21F"=>"textx4","vis_23W"=>30,
		//Benjolan / tumor lokasi
		"vis_24"=>"","vis_25"=>"","vis_26"=>"","vis_27"=>"","vis_28"=>"","vis_29"=>"","vis_30"=>"","vis_31"=>"",		    
		"vis_32"=>"","vis_33"=>"","vis_34"=>"","vis_35"=>"","vis_36"=>"","vis_37"=>"","vis_38"=>"","vis_39"=>"",					
		"vis_32F"=>"textx3","vis_32W"=>30,
		"vis_40"=>"Catatan / Uraian"										, "vis_40F"=>"memo","vis_40W"=>50,
	//pemeriksaan ginekologi
		//porsio ==> checkbox
		//"vis_41"=>"Licin","vis_42"=>"Ertoplakia","vis_43"=>"Endofitik","vis_44"=>"Eksofirik","vis_45"=>"Ulceratif","vis_41F"=>"textx5","vis_41W"=>30,  								     			, "vis_45F"=>"checkbox","vis_45W"=>30,
		"vis_41"=>"Licin"	,"vis_42"=>"Ertoplakia   ","vis_43"=>"Endofitik","vis_44"=>"Eksofirik","vis_45"=>"Ulceratif", "vis_41F"=>"textx5","vis_41W"=>10,
		"vis_46"=>"","vis_47"=>"","vis_48"=>""           	, "vis_46F"=>"text1x","vis_46W"=>30,
		"vis_49"=>"Lokasi Tumor"											, "vis_49F"=>"memo1","vis_49W"=>50,
		"vis_50"=>"Sondase Uterus"											, "vis_50F"=>"edit","vis_50W"=>30,
		"vis_51"=>"Catatan / Uraian"										, "vis_51F"=>"edit","vis_51W"=>50,
		"vis_52"=>"Laboratorium Dasar","vis_53"=>"HB","vis_54"=>"Lekosit"	, "vis_52F"=>"edit","vis_52W"=>30,
		
		
);

//klinik kebidanan_obsteteri/ kandungan/melahirkan
$visit_obsteteri = array(
		//kedatangan
		"vis_1" =>"Dikirim Oleh", "vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Diagnosis Kerja Pengirim"											, "vis_2F"=>"memo","vis_2W"=>50,
		"vis_3" =>"Tanggal "		, "vis_3F"=>"edit","vis_3W"=>30,
		"vis_4" =>"Anamnesis Oleh","vis_4F"=>"edit","vis_4W"=>30,
		"vis_5" =>"Diberikan Oleh", "vis_5F"=>"edit","vis_5W"=>30,
		"vis_6" =>"Pendidikan Terakhir","vis_7" =>"Tahun", "vis_8" =>"Jabatan Terakhir"		, "vis_6F"=>"edit3","vis_6W"=>30,
		//riwayat anak
		"vis_9" =>"Anak Hidup ", "vis_10"=>"Anak Mati", "vis_11"=>"Jumlah Semua" 	, "vis_9F"=>"edit4","vis_9W"=>30,
		"vis_12" =>"Keguguran ", "vis_13"=>"Lahir Mati", "vis_14"=>"Lain-lain"  , "vis_12F"=>"edit7","vis_12W"=>30,
		//riwayat kelahiran
		"vis_15"=>"Usia Kandungan " 							, "vis_15F"=>"check1","vis_15W"=>30,
		"vis_16" =>"Penolong ", "vis_17"=>"Jenis Kelahiran", "vis_18"=>"Tempat Kelahiran" 	, "vis_16F"=>"edit5","vis_16W"=>30,
		"vis_19" =>"Kelainan Bawaan ", "vis_20"=>"Berat Badan Saat Lahir", "vis_21"=>"Panjang Badan Saat Lahir"  , "vis_19F"=>"edit7","vis_19W"=>30,
		//pertumbuhan bayi (motorik,Bicara,gigi,geligi)
		"vis_22"=>"Pertumbuhan dan Perkembangan "	  						, "vis_22F"=>"edit","vis_22W"=>50,
		"vis_23"=>"Catatan Makanan "	  						, "vis_23F"=>"edit","vis_23W"=>50,
		//imunisasi
		"vis_24"=>"Cacar"		, "vis_25"=>"Polio" 	  					, "vis_24F"=>"edit2","vis_24W"=>30,
		"vis_26"=>"D.P.T"	   	, "vis_27"=>"B.C.G" 	  					, "vis_26F"=>"edit2","vis_26W"=>30,
		"vis_28"=>"Chotypa"		, "vis_29"=>"Lain-lain" 	  				, "vis_28F"=>"edit2","vis_28W"=>30,
		//penyakit terdahulu (sebutkan tanggal/ umur)
		"vis_30"=>"Cacar"		,"vis_31"=>"Tetanus"						, "vis_30F"=>"edit2","vis_30W"=>30,
		"vis_32"=>"Dipteri"		,"vis_33"=>"Morbili"						, "vis_32F"=>"edit2","vis_32W"=>30,
		"vis_34"=>"Batuk Rejam"	,"vis_35"=>"Parotis"						, "vis_34F"=>"edit2","vis_34W"=>30,
		"vis_36"=>"Varicella"	,"vis_37"=>"Lain-lain"						, "vis_36F"=>"edit2","vis_36W"=>30,
		//Riwayat Obsterik
		"vis_38"=>"G-P-A Anak Hidup"										, "vis_38F"=>"edit","vis_38W"=>30,
		"vis_39"=>"Kehamilan Terakhir"										, "vis_39F"=>"memo","vis_39W"=>50,
		//mbuh....
		"vis_40"=>"Keluhan Utama"											, "vis_40F"=>"memo","vis_40W"=>50,
		"vis_41"=>"Keluhan Tambahan"										, "vis_41F"=>"memo","vis_41W"=>50,
		"vis_42"=>"Perjalanan Penyakit"	, "vis_42F"=>"memo","vis_42W"=>50,
		"vis_43"=>"Penyakit Dalam Keluarga"					, "vis_43F"=>"memo","vis_43W"=>50,
		"vis_44"=>"Riwayat Hamil"											, "vis_44F"=>"memo","vis_44W"=>50,
		"vis_45"=>"Analisa"													, "vis_45F"=>"memo","vis_45W"=>50,
		"vis_46"=>"Diagnosa Terakhir"										, "vis_46F"=>"memo","vis_46W"=>50,
		"vis_47"=>"Rencana Pengobatan"										, "vis_47F"=>"memo","vis_47W"=>50,
		"vis_48"=>"Anjuran Pemeriksaan"										, "vis_48F"=>"memo","vis_48W"=>50,
		"vis_49"=>"Terapi"													, "vis_49F"=>"memo","vis_49W"=>50,
		"vis_50"=>"Orang Tua"												, "vis_50F"=>"edit","vis_50W"=>50,
		"vis_51"=>"Perkawinan " 											, "vis_51F"=>"check1","vis_51W"=>30,
		"vis_52"=>"Tensi " 											, "vis_52F"=>"memo","vis_52W"=>30,
		"vis_53"=>"Berat Badan " 											, "vis_53F"=>"memo","vis_53W"=>30,

);

$visit_psikiatri = array (
		"vis_1"=>"Keluhan Utama"   											, "vis_1F"=>"memo1","vis_1W"=>50,
		"vis_2"=>"Pemeriksaan Umum"  										, "vis_2F"=>"memo2","vis_2W"=>50, 
		"vis_3"=>"Lain-Lain"												, "vis_3F"=>"memo3","vis_3W"=>50,
		"vis_4"=>"Diagnosa" 												, "vis_4F"=>"memo4","vis_4W"=>50,
);
//febri 26112012
$visit_saraf = array (
		"vis_1"=>"Tgl Datang Pertama" 										, "vis_1F"=>"memo1","vis_1W"=>50,
		"vis_2"=>"Anamnesa"   												, "vis_2F"=>"memo1","vis_2W"=>50,
		"vis_3"=>"Pemeriksaan Fisik"  										, "vis_3F"=>"memo2","vis_3W"=>50, 
		"vis_4"=>"Pemeriksaan Lain-lain"									, "vis_4F"=>"memo3","vis_4W"=>50,
		"vis_5"=>"Diagnosa Kerja" 											, "vis_5F"=>"memo4","vis_5W"=>50,
		"vis_6"=>"Pengobatan" 												, "vis_6F"=>"memo4","vis_6W"=>50,
		"vis_7"=>"Keluhan Utama" 											, "vis_7W"=>50,
);

//============================ RAWAT INAP ===============================================

$visit_ri_riwayat_penyakit = array (
		"vis_1"=>"Dokter Jaga "   											, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Dokter Ruangan "  										, "vis_2F"=>"edit","vis_2W"=>50, 
		"vis_3"=>"Penyakit "												, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Diagnosis I) " 											, "vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Anamnesa " 												, "vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Keadaan Umum"												, "vis_6F"=>"edit","vis_6W"=>10,
		"vis_7"=>"Keadaan Tubuh" 											, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"Keadaan Ingatan " 										, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"Kulit ","vis_10"=>"Suhu" 									, "vis_9F"=>"edit","vis_9W"=>10,
		"vis_11"=>"Selaput Lendir ","vis_12"=>"Oedem" 						, "vis_11F"=>"edit","vis_11W"=>10,
		"vis_13"=>"Lidah","vis_14"=>"Tenggorokan" 							, "vis_13F"=>"edit","vis_13W"=>10,
		"vis_15"=>"Gigi","vis_16"=>"Hidung" 								, "vis_15F"=>"edit","vis_15W"=>10,
		"vis_17"=>"Telinga","vis_18"=>"Mata" 								, "vis_17F"=>"edit","vis_17W"=>10,
		"vis_19"=>"Leher","vis_20"=>"Dada" 									, "vis_19F"=>"edit","vis_19W"=>10,
		"vis_21"=>"Pernapasan","vis_22"=>"Jantung" 							, "vis_21F"=>"edit","vis_21W"=>10,
		"vis_23"=>"Tekanan Darah","vis_24"=>"Nadi" 							, "vis_23F"=>"edit","vis_23W"=>10,
		"vis_25"=>"Perut","vis_26"=>"Hati" 									, "vis_25F"=>"edit","vis_25W"=>10,
		"vis_27"=>"Limpa","vis_28"=>"Kemaluan" 								, "vis_27F"=>"edit","vis_27W"=>10,
		"vis_29"=>"Susunan Otot","vis_30"=>"Susunan Tulang Dan Sendi" 		, "vis_29F"=>"edit","vis_29W"=>10,
		"vis_31"=>"Pergerakan Anggota","vis_32"=>"Perasaan" 				, "vis_31F"=>"edit","vis_31W"=>10,
		"vis_33"=>"Refleks"													, "vis_33F"=>"edit","vis_33W"=>10,
		"vis_34"=>"HB","vis_35"=>"Leucosit","vis_36"=>"Hitung Jenis"  		, "vis_34F"=>"edit","vis_34W"=>30,
		"vis_37"=>"VDRL","vis_38"=>"LED","vis_39"=>"WR","vis_40"=>"Kahn" 	, "vis_37F"=>"edit","vis_37W"=>30,
		"vis_41"=>"Urine","vis_42"=>"Feases","vis_43"=>"Lain-Lain"			, "vis_41F"=>"edit","vis_41W"=>30,
		"vis_44"=>"Keterangan Lain-Lain"											, "vis_44F"=>"memo","vis_44W"=>50,
		"vis_45"=>"No. Kode"												, "vis_45F"=>"edit","vis_45W"=>10,
		"vis_46"=>"Diagnosis Sementara"										, "vis_46F"=>"edit","vis_46W"=>10,
		);
		
$visit_ri_catatan_kebidanan = array (
		"vis_1"=>"Dokter Jaga "   											, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Dokter Ruangan "  										, "vis_2F"=>"edit","vis_2W"=>50, 
		"vis_3"=>"Penyakit Bersamaan"										, "vis_3F"=>"edit","vis_3W"=>60,
		"vis_4"=>"Penyakit Dahulu" 											, "vis_4F"=>"edit","vis_4W"=>60,
		"vis_5"=>"Tanggal" 													, "vis_5F"=>"edit","vis_5W"=>10,
		"vis_6"=>"Waktu"													, "vis_6F"=>"edit5","vis_6W"=>10,
		//anamnesa
		"vis_7"=>"Alasan Dirawat" 											, "vis_7F"=>"memo","vis_7W"=>50,
		//haid
		"vis_8"=>"Nebarche" 												, "vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"Lamanya Haid","vis_10"=>"Dysmenorrhoe" 					, "vis_9F"=>"edit","vis_9W"=>10,
		"vis_11"=>"Cylus","vis_12"=>"Banyaknya" 							, "vis_11F"=>"edit","vis_11W"=>10,
		"vis_13"=>"Hari"								 					, "vis_13F"=>"edit","vis_13W"=>10,
		"vis_14"=>"Haid Terakhir" 												, "vis_14F"=>"edit","vis_14W"=>10,
		"vis_15"=>"Perkawinan","vis_16"=>"Dengan Suami Sekarang" 			, "vis_15F"=>"edit","vis_15W"=>10,
		//riwayat kehamilan dan persalinan
		"vis_17"=>"Keadaan Anak Kehamilan Ke 1" 							,"vis_17F"=>"text1","vis_17W"=>30,
		"vis_18"=>"Ditolong Oleh"											,"vis_18F"=>"text1","vis_18W"=>30,
		"vis_19"=>"Keterangan"											,"vis_19F"=>"text1","vis_19W"=>30,
		"vis_20"=>"Keadaan Anak Kehamilan Ke 2"								,"vis_20F"=>"text1","vis_20W"=>30,
		"vis_21"=>"Ditolong Oleh"											,"vis_21F"=>"text1","vis_21W"=>30,
		"vis_22"=>"Keterangan"											,"vis_22F"=>"text1","vis_22W"=>30,
		"vis_23"=>"Keadaan Anak Kehamilan Ke 3"								,"vis_23F"=>"text1","vis_23W"=>30,
		"vis_24"=>"Ditolong Oleh"											,"vis_24F"=>"text1","vis_24W"=>30,		    
		"vis_25"=>"Keterangan"											,"vis_25F"=>"text1","vis_25W"=>30,
		"vis_26"=>"Keadaan Anak Kehamilan Ke 4"								,"vis_26F"=>"text1","vis_26W"=>30,
		"vis_27"=>"Ditolong Oleh"											,"vis_26F"=>"text1","vis_26W"=>30,
		"vis_28"=>"Keterangan"											,"vis_27F"=>"text1","vis_27W"=>30,
		"vis_29"=>"Keadaan Anak Kehamilan Ke 5"								,"vis_28F"=>"text1","vis_28W"=>30,
		"vis_30"=>"Ditolong Oleh"											,"vis_29F"=>"text1","vis_29W"=>30,
		"vis_31"=>"Keterangan"											,"vis_30F"=>"text1","vis_30W"=>30,					
		"vis_32"=>"Penyakit Operasi Yang Lalu" 								, "vis_32F"=>"memo","vis_32W"=>50,
		//Kehamilan sekarang
		"vis_33"=>"Haid Terakhir"											, "vis_33F"=>"edit","vis_33W"=>30,
		"vis_34"=>"Pengawasan Kehamilan"									, "vis_34F"=>"edit","vis_34W"=>30,
		"vis_35"=>"Di"														, "vis_35F"=>"edit","vis_35W"=>30,
		"vis_36"=>"Hal Ikhwal Kehamilan"									, "vis_36F"=>"memo","vis_36W"=>50,
		//status praesens
		"vis_37"=>"Nadi","vis_38"=>"Tensi","vis_39"=>"Suhu","vis_40"=>"Pernafasan", "vis_37F"=>"edit","vis_37W"=>10,
		"vis_41"=>"Cor","vis_42"=>"Pulmo","vis_43"=>"Hepar","vis_44"=>"Lien", "vis_41F"=>"edit","vis_41W"=>10,
		"vis_45"=>"Extremitas","vis_46"=>"Lain-Lain"						,"vis_45F"=>"edit","vis_45W"=>10,
		//status obstetrikus
		//pemeriksaan Luar
		"vis_47"=>"Tinggi Fundus Uteri","vis_48"=>"Letak Anak","vis_49"=>"Punggung","vis_50"=>"Denyut Jantung", "vis_47F"=>"edit","vis_47W"=>10,
		"vis_51"=>"His","vis_52"=>"Lain-Lain"								, "vis_51F"=>"edit","vis_51W"=>10,
		"vis_53"=>"Pemeriksaan Dalam","vis_54"=>"Pemeriksaan Panggul Dalam"	,"vis_53F"=>"edit","vis_53W"=>10,
		//pemeriksaan Lab
		"vis_55"=>"HB","vis_56"=>"Leukosit","vis_57"=>"Hitung Jenis","vis_58"=>"VDRL", "vis_55F"=>"edit","vis_55W"=>10,
		"vis_59"=>"LED","vis_60"=>"WR","vis_61"=>"Kahn"						, "vis_59F"=>"edit","vis_59W"=>10,
		"vis_62"=>"Urine","vis_63"=>"Fecces","vis_64"=>"Lain-Lain"			, "vis_62F"=>"edit","vis_62W"=>10,
		"vis_65"=>"Kesimpulan"												, "vis_65F"=>"memo","vis_65W"=>50,
		//riwayat persalinan
		"vis_66"=>"Tanggal"													, "vis_66F"=>"edit","vis_66W"=>50,
		"vis_67"=>"Waktu"													, "vis_67F"=>"edit","vis_67W"=>50,
		"vis_68"=>"Keterangan"												, "vis_68F"=>"edit","vis_68W"=>50,
		
		
		);
		
$visit_ri_catatan_bayi = array (
		//IBU
		"vis_1"=>"Umur"   													, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Para"  													, "vis_2F"=>"edit","vis_2W"=>50, 
		"vis_3"=>"Prematur"													, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Abortus" 													, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Anak Hidup" 												, "vis_5F"=>"edit","vis_5W"=>10,
		"vis_6"=>"Sc"														, "vis_6F"=>"edit5","vis_6W"=>10,
		"vis_7"=>"Riwayat Tuberkulosisi" 									, "vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"Venerik" 													, "vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"VDRL","vis_10"=>"WR" 										, "vis_9F"=>"edit","vis_9W"=>10,
		"vis_11"=>"Diabetes","vis_12"=>"Vitium Cordis" 						, "vis_11F"=>"edit","vis_11W"=>10,
		"vis_13"=>"Lain-Lain"												, "vis_13F"=>"edit","vis_13W"=>10,
		//Golongan darah
		"vis_14"=>"RH Ayah" 												, "vis_14F"=>"edit","vis_14W"=>10,
		"vis_15"=>"RH Ibu","vis_16"=>"Coombs tes" 							, "vis_15F"=>"edit","vis_15W"=>10,
		"vis_17"=>"Jenis Persalinan","vis_18"=>"Atas Indikasi"				,"vis_17F"=>"memo","vis_17W"=>50,
		"vis_19"=>"Komplikasi"												,"vis_19F"=>"memo","vis_19W"=>50,
		"vis_20"=>"Obat"													,"vis_20F"=>"memo","vis_20W"=>50,
		"vis_21"=>"Cara Pemberian"											,"vis_21F"=>"memo","vis_21W"=>30,
		"vis_22"=>"Pemberian Terakhir"										,"vis_22F"=>"memo","vis_22W"=>30,
		//anestesi
		"vis_23"=>"Obat"													,"vis_23F"=>"memo","vis_23W"=>30,
		"vis_24"=>"Cara Pemberian"											,"vis_24F"=>"memo","vis_24W"=>30,
		"vis_25"=>"Pemberian Terakhir"										,"vis_25F"=>"memo","vis_25W"=>30,
		//BAYI
		"vis_26"=>"Tanggal Lahir"											,"vis_26F"=>"edit","vis_26W"=>30,
		"vis_27"=>"Waktu"													,"vis_27F"=>"edit","vis_27W"=>30,
		"vis_28"=>"Jenis Kelamin"											,"vis_28F"=>"edit","vis_28W"=>30,
		"vis_29"=>"Kembar"													,"vis_29F"=>"edit","vis_29W"=>30,
		//penilaian bayi
		"vis_30"=>"","vis_31"=>"","vis_32"=>""								,"vis_30F"=>"edit","vis_30W"=>30,
		"vis_33"=>"Jumlah Nilai"											,"vis_33F"=>"edit","vis_33W"=>30,
		"vis_34"=>"","vis_35"=>"","vis_36"=>""								,"vis_34F"=>"edit","vis_34W"=>30,
		"vis_37"=>"Jumlah Nilai"											,"vis_37F"=>"edit","vis_37W"=>30,
		"vis_38"=>"","vis_39"=>"","vis_40"=>""								,"vis_38F"=>"edit","vis_38W"=>30,
		"vis_41"=>"Jumlah Nilai"											,"vis_39F"=>"edit","vis_39W"=>30,
		"vis_42"=>"","vis_43"=>"","vis_44"=>""								,"vis_42F"=>"edit","vis_42W"=>30,
		"vis_45"=>"Jumlah Nilai"											,"vis_45F"=>"edit","vis_45W"=>30,
		"vis_46"=>"","vis_47"=>"","vis_48"=>""								,"vis_46F"=>"edit","vis_46W"=>30,
		"vis_49"=>"Jumlah Nilai"											,"vis_49F"=>"edit","vis_49W"=>30,
		//resuitasi
		"vis_50"=>"Pemberian Oxygen"										,"vis_50F"=>"edit","vis_50W"=>30,
		"vis_51"=>"Peniupan"												,"vis_51F"=>"edit","vis_51W"=>30,
		"vis_52"=>"Pemberian Oxygen Dalam Tekanan"									,"vis_52F"=>"edit","vis_52W"=>30,
		"vis_53"=>"Pernafasan Mulut Ke Mulut"								,"vis_53F"=>"edit","vis_53W"=>30,
		//kisah resuitasi
		"vis_54"=>"Waktu Sampai Bernafas Teratur"							,"vis_54F"=>"edit","vis_54W"=>30,
		"vis_55"=>"Pengobatan Bayi"											,"vis_55F"=>"edit","vis_55W"=>30,
		"vis_56"=>"Waktu Sampai Menangis"									,"vis_56F"=>"edit","vis_56W"=>30,
		//pemeriksaan bayi setelah lahir
		"vis_57"=>"Kepala","vis_58"=>"Kulit","vis_59"=>"Jantung","vis_60"=>"Mata","vis_57F"=>"edit","vis_57W"=>50,
		"vis_61"=>"Paru","vis_62"=>"Hidung","vis_63"=>"Abdomen","vis_64"=>"Mulut","vis_61F"=>"edit","vis_61W"=>30,
		"vis_65"=>"Anus","vis_66"=>"Telinga","vis_67"=>"Extremitas"			,"vis_65F"=>"edit","vis_65W"=>30,
		"vis_68"=>"Anjuran"													,"vis_68F"=>"edit","vis_68W"=>50,
		"vis_69"=>"Meninggal Tanggal","vis_70"=>"Waktu"						,"vis_69F"=>"edit","vis_69W"=>30,
		"vis_71"=>"Umur Bayi"												,"vis_71F"=>"edit","vis_71W"=>30,
		"vis_72"=>"Sebab Kematian"											,"vis_72F"=>"edit","vis_72W"=>30,
		"vis_73"=>"Obduksi"													,"vis_73F"=>"memo","vis_73W"=>30,
		//ukuran bayi
		"vis_74"=>"Berat Badan","vis_75"=>"Panjang Badan","vis_76"=>"Bip","vis_77"=>"OM","vis_78"=>"OF","vis_74F"=>"edit","vis_74W"=>30,
		);
		
$visit_ri_catatan_perkembangan_bayi = array (
		"vis_1"=>"Waktu" ,"vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Catatan" ,"vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Tanggal" ,"vis_3F"=>"edit","vis_3W"=>50,
		);
		
$visit_ri_resume_keb = array (
		//diagnosa obstetrik
		"vis_1"=>"Waktu Masuk G.P.A" ,"vis_1F"=>"memo","vis_1W"=>30,
		"vis_2"=>"Waktu Keluar G.P.A" ,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Tindakan" ,"vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Tanggal Lahir","vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Jenis Kelamin" ,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"Berat" ,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Panjang" ,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Keadaan","vis_8F"=>"memo","vis_8W"=>30,
		//riwayat obstetrik
		"vis_9"=>"Obstetrik Terdahulu" ,"vis_9F"=>"memo","vis_9W"=>50,
		"vis_10"=>"Operasi Terdahulu" ,"vis_10F"=>"memo","vis_10W"=>50,
		//riwayat kehamilan sekarang
		"vis_11"=>"Haid Terakhir" ,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Lamanya","vis_12F"=>"memo","vis_12W"=>30,
		"vis_13"=>"Haid Sebelumnya" ,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Tafsiran Persalinan" ,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Kelainan Kehamilan" ,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Obat Yang Pernah Dimakan","vis_16F"=>"memo","vis_16W"=>30,
		//laboratorium
		"vis_17"=>"HB" ,"vis_17F"=>"memo","vis_17W"=>30,
		"vis_18"=>"Golongan Darah" ,"vis_18F"=>"memo","vis_18W"=>30,
		"vis_19"=>"Faktor RH" ,"vis_19F"=>"memo","vis_19W"=>30,
		"vis_20"=>"Leukosit","vis_20F"=>"memo","vis_20W"=>30,
		"vis_21"=>"Wr" ,"vis_21F"=>"memo","vis_21W"=>30,
		"vis_22"=>"VDR" ,"vis_22F"=>"memo","vis_22W"=>30,
		"vis_23"=>"Kahn" ,"vis_23F"=>"memo","vis_23W"=>30,
		"vis_24"=>"Nuther","vis_24F"=>"memo","vis_24W"=>30,
		"vis_25"=>"2 Jam/Post Prandial" ,"vis_25F"=>"memo","vis_25W"=>30,
		"vis_26"=>"Urine" ,"vis_26F"=>"memo","vis_26W"=>30,
		"vis_27"=>"Lain-Lain" ,"vis_27F"=>"memo","vis_27W"=>30,
		//riwayat persalinan sekarang
		"vis_28"=>"Lamanya","vis_28F"=>"memo","vis_28W"=>30,
		"vis_29"=>"Jenis Kelainan" ,"vis_29F"=>"memo","vis_29W"=>30,
		"vis_30"=>"Tindakan" ,"vis_30F"=>"memo","vis_30W"=>50,
		"vis_31"=>"Ketuban Pecah" ,"vis_31F"=>"memo","vis_31W"=>30,
		"vis_32"=>"Lamanya","vis_32F"=>"memo","vis_32W"=>30,
		"vis_33"=>"Jenis Kelainan" ,"vis_33F"=>"memo","vis_33W"=>30,
		"vis_34"=>"Tindakan" ,"vis_34F"=>"memo","vis_34W"=>50,
		"vis_35"=>"Lamanya","vis_35F"=>"memo","vis_35W"=>30,
		"vis_36"=>"Jenis Kelainan" ,"vis_36F"=>"memo","vis_36W"=>30,
		"vis_37"=>"Tindakan" ,"vis_37F"=>"memo","vis_37W"=>50,
		"vis_38"=>"Lamanya","vis_38F"=>"memo","vis_38W"=>30,
		"vis_39"=>"Jenis Kelainan" ,"vis_39F"=>"memo","vis_39W"=>30,
		"vis_40"=>"Tindakan" ,"vis_40F"=>"memo","vis_40W"=>50,
		"vis_41"=>"Dokter Yang Merawat","vis_41F"=>"memo","vis_41W"=>30,
		"vis_42"=>"Dokter Pengirim" ,"vis_42F"=>"memo","vis_42W"=>30,
		"vis_43"=>"Alat Pengirim" ,"vis_43F"=>"memo","vis_43W"=>30,
		);
		
$visit_ri_resume_bayi = array (
		//diagnosa akhir
		"vis_1"=>"Dokter Yang Merawat" ,"vis_1F"=>"memo","vis_1W"=>30,
		"vis_2"=>"Dokter Pengirim" ,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Alat Pengirim" ,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Diagnosis Akhir 1","vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Diagnosis Akhir 2" ,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Diagnosis Akhir 3" ,"vis_6F"=>"memo","vis_6W"=>50,
		//riwayat kelahiran
		"vis_7"=>"G.P.A Kehamilan" ,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Tanggal","vis_8F"=>"memo","vis_8W"=>30,
		"vis_9"=>"Jam" ,"vis_9F"=>"memo","vis_9W"=>30,
		"vis_10"=>"Secara" ,"vis_10F"=>"memo","vis_10W"=>30,
		"vis_11"=>"Apgar Score" ,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Air Ketuban","vis_12F"=>"memo","vis_12W"=>30,
		//pemeriksaan
		"vis_13"=>"Berat Badan" ,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Panjang Badan" ,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Lingkar Kepala" ,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Kepala","vis_16F"=>"memo","vis_16W"=>30,
		"vis_17"=>"Kelainan Fisik" ,"vis_17F"=>"memo","vis_17W"=>50,
		"vis_18"=>"Laboratorium" ,"vis_18F"=>"memo","vis_18W"=>50,
		//tindak lanjut
		"vis_19"=>"Minum" ,"vis_19F"=>"memo","vis_19W"=>30,
		"vis_20"=>"Berat Badan Minimum","vis_20F"=>"memo","vis_20W"=>30,
		"vis_21"=>"Hari Ke" ,"vis_21F"=>"memo","vis_21W"=>30,
		"vis_22"=>"Hari Ke" ,"vis_22F"=>"memo","vis_22W"=>30,
		"vis_23"=>"Pulang Dengan Berat Badan" ,"vis_23F"=>"memo","vis_23W"=>30,
		"vis_24"=>"Posisi Bayi" ,"vis_24F"=>"memo","vis_24W"=>30,
		"vis_25"=>"Seorang Bayi" ,"vis_25F"=>"memo","vis_25W"=>30,
		"vis_26"=>"Diberi Tetes Mata Untuk Pencegahan Dan" ,"vis_26F"=>"memo","vis_26W"=>30,
		);

$visit_ri_resume = array (
		//diagnosa akhir
		"vis_1"=>"Dokter Yang Merawat" ,"vis_1F"=>"memo","vis_1W"=>30,
		"vis_2"=>"Dokter Pengirim" ,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Alat Pengirim" ,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Diagnosis Masuk","vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Diagnosis Akhir" ,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Pembedahan" ,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Pembedahan Khusus" ,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Riwayat Penyakit","vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"Alergi" ,"vis_9F"=>"memo","vis_9W"=>30,
		"vis_10"=>"Pemeriksaan Fisik" ,"vis_10F"=>"memo","vis_10W"=>50,
		//laboratorium
		"vis_11"=>"X Fhoto" ,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"EKG","vis_12F"=>"memo","vis_12W"=>30,
		"vis_13"=>"Patologi" ,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Lain-Lain" ,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Konsultasi" ,"vis_15F"=>"memo","vis_15W"=>50,
		"vis_16"=>"Perjalanan Penyakit","vis_16F"=>"memo","vis_16W"=>50,
		"vis_17"=>"Pengobatan" ,"vis_17F"=>"memo","vis_17W"=>50,
		"vis_18"=>"Sakit" ,"vis_18F"=>"memo","vis_18W"=>50,
		//keperluan
		"vis_19"=>"Obat-Obatan" ,"vis_19F"=>"memo","vis_19W"=>30,
		"vis_20"=>"Nasehat","vis_20F"=>"memo","vis_20W"=>50,
		"vis_21"=>"Periksa Ulang" ,"vis_21F"=>"memo","vis_21W"=>30,
		"vis_22"=>"Tindakan Ulang" ,"vis_22F"=>"memo","vis_22W"=>30,

		);

$visit_ri_ringkasan_masuk_keluar = array (
		
		"vis_1"=>"Dokter Yang Mengirim" ,"vis_1F"=>"memo","vis_1W"=>30,
		"vis_2"=>"Dokter Ruangan" ,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Alamat Dokter Pengirim" ,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Tanggal Masuk","vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Jam" ,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"Tanggal Keluar" ,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Jam" ,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Tanggal Meninggal","vis_8F"=>"memo","vis_8W"=>30,
		"vis_9"=>"Jam" ,"vis_9F"=>"memo","vis_9W"=>30,
		"vis_10"=>"Jumlah Hari Perawatan" ,"vis_10F"=>"memo","vis_10W"=>30,
		"vis_11"=>"Pindah Ke" ,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Diagnosa Sementara","vis_12F"=>"memo","vis_12W"=>50,
		"vis_13"=>"Diagnosa Akhir" ,"vis_13F"=>"memo","vis_13W"=>50,
		"vis_14"=>"Diagnosa Sekunder" ,"vis_14F"=>"memo","vis_14W"=>50,
		"vis_15"=>"Operasi" ,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Sebab Terjadi Kecelakaan","vis_16F"=>"memo","vis_16W"=>50,
		"vis_17"=>"Tempat Kejadian" ,"vis_17F"=>"memo","vis_17W"=>30,
		"vis_18"=>"Pengobatan Dilanjutkan Di" ,"vis_18F"=>"memo","vis_18W"=>30,
		"vis_19"=>"Tanggal" ,"vis_19F"=>"memo","vis_19W"=>30,
		"vis_20"=>"Otopsi","vis_20F"=>"memo","vis_20W"=>30,
		"vis_21"=>"Ruangan","vis_21F"=>"memo","vis_21W"=>30,
		"vis_22"=>"Tanda Tangan Perawat","vis_22F"=>"memo","vis_22W"=>30,

		);
		
$visit_ri_laporan_pembedahan = array (
//jenis pembedahan dibagi menjadi 3 macam
		
		"vis_1"=>"Bedah" 					,"vis_1F"=>"memo","vis_1W"=>30,
		"vis_2"=>"Asisten Bedah" 			,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Anestesi" 				,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Asisten Anestesi"			,"vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Konsulen" 				,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"Pra Bedah" 				,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Diagnosa Pasca Bedah" 	,"vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"Posisi"					,"vis_8F"=>"memo","vis_8W"=>30,
		//Jenis Pembedahan (akut/non akut)
		"vis_9"=>"Jenis Pembedahan" 		,"vis_9F"=>"memo","vis_9W"=>30,
		//pembedahan (besar/kecil/sedang)
		"vis_10"=>"Pembedahan" 		,"vis_10F"=>"memo","vis_10W"=>30,
		//pembedahan (berencanan/gawat darurat)
		"vis_11"=>"Pembedahan" 		,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Mulai (Pukul)" 			,"vis_12F"=>"memo","vis_12W"=>30,
		"vis_13"=>"Selesai (Pukul)" 		,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Lama Pembedahan"			,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Anestesi" 				,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Laporan Pembedahan" 		,"vis_16F"=>"memo","vis_16W"=>50,

		);
		
$visit_ri_proses_keperawatan = array(

		"vis_1"=>"waktu"					,"vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Diagnosa Keperawatan"		,"vis_2F"=>"memo","vis_2W"=>50,		
		"vis_3"=>"Rencana Keperawatan"		,"vis_3F"=>"memo","vis_3W"=>50,
	//tambahan 21-10-2007
	//Evaluasi	
		"vis_4"=>"S"						,"vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"O"						,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"A"						,"vis_6F"=>"memo","vis_6W"=>50,
		"vis_7"=>"P"						,"vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"Tanggal"					,"vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"Nama Jelas"				,"vis_9F"=>"memo","vis_9W"=>50,
		"vis_10"=>"Tindakan Keperawatan"	,"vis_10F"=>"memo","vis_10W"=>50,
		);		
		
$visit_ri_asuhan_keperawatan = array (
		
		"vis_1"=>"Keluhan Utama" 				,"vis_1F"=>"memo","vis_1W"=>50,
		"vis_2"=>"Riwayat Penyakit Dahulu" 		,"vis_2F"=>"memo","vis_2W"=>50,
		"vis_3"=>"Riwayat Penyakit Sekarang" 	,"vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Masalah Keperawatan 1" 		,"vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"Masalah Keperawatan 2" 		,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Masalah Keperawatan 3" 		,"vis_6F"=>"memo","vis_6W"=>50,
		"vis_7"=>"Masalah Keperawatan 4"		,"vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"Masalah Keperawatan 5" 		,"vis_8F"=>"memo","vis_8W"=>50,

		);

$visit_ri_lembar_konsultasi = array(
		
		"vis_1"=>"Konsulen"                     						,"vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Diagnosis Sementara"          						,"vis_2F"=>"memo","vis_2W"=>50,
		"vis_3"=>"Laporan Klinik dari Dokter"   						,"vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Konsulen diharapkan untuk mengambil alih perawatan" 	,"vis_4F"=>"edit","vis_4W"=>30,
		"vis_5"=>"Pendapat Konsulen"            						,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"Saran dan Lanjutan Medikasi"  						,"vis_6F"=>"memo","vis_6W"=>50,
		"vis_7"=>"Dokter"  											,"vis_7F"=>"memo","vis_7W"=>30,
		
		);

$visit_ri_hasil_EKG = array(
			
		"vis_1"=>"Nama yang Merekam" 		,"vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Keterangan" 		,"vis_2F"=>"memo","vis_2W"=>30,
		
		/*"vis_2"=>"I"                     	,"vis_2F"=>"memo","vis_2W"=>50,
		"vis_3"=>"II"			          	,"vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"III"					  	,"vis_4F"=>"memo","vis_4W"=>50,
		"vis_5"=>"AVR" 						,"vis_5F"=>"memo","vis_5W"=>50,
		"vis_6"=>"AVL"	 			        ,"vis_6F"=>"memo","vis_6W"=>50,
		"vis_7"=>"AVF"  					,"vis_7F"=>"memo","vis_7W"=>50,
		"vis_8"=>"V1" 	 					,"vis_8F"=>"memo","vis_8W"=>50,
		"vis_9"=>"V2" 	 					,"vis_9F"=>"memo","vis_9W"=>50,
		"vis_10"=>"V3" 	 					,"vis_10F"=>"memo","vis_10W"=>50,
		"vis_11"=>"V4" 	 					,"vis_11F"=>"memo","vis_11W"=>50,
		"vis_12"=>"V5" 	 					,"vis_12F"=>"memo","vis_12W"=>50,
		"vis_13"=>"V6" 	 					,"vis_13F"=>"memo","vis_13W"=>50,*/
		"vis_14"=>"Tanggal Perekaman" 	 	,"vis_14F"=>"edit","vis_14W"=>30,
		"vis_15"=>"Pukul" 	 				,"vis_15F"=>"edit","vis_15W"=>30,
		
		);

$visit_ri_catatan_obstetri = array(
			
		"vis_1"=>"Tiba di tempat bersalin" 		,"vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Dokter/Bidan"                     	,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Frekuensi"			          		,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Lamanya"					  			,"vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Kekuatan" 							,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"relaxasi"	 			        		,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Frekuensi D.I.A"  					,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Bidan/Perawat" 	 					,"vis_8F"=>"memo","vis_8W"=>30,
		"vis_9"=>"Tanggal" 	 							,"vis_9F"=>"memo","vis_9W"=>30,
		"vis_10"=>"Jam" 	 							,"vis_10F"=>"memo","vis_10W"=>30,
		
		);

$visit_ri_pengawasan_pasien_anak = array(
		//peraturan
		"vis_1"=>"Makanan"					,"vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Pengobatan"                	,"vis_2F"=>"memo","vis_2W"=>50,
		"vis_3"=>"Pemeriksaan Laboratorium MANTOUX"		,"vis_3F"=>"memo","vis_3W"=>50,
		"vis_4"=>"Perhatian Khusus"			  			,"vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Consul"								,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"Suhu"		 			        		,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Nadi"				  					,"vis_7F"=>"memo","vis_7W"=>30,
		"vis_8"=>"Pernafasan"	 	 					,"vis_8F"=>"memo","vis_8W"=>30,
		"vis_9"=>"Muntah"		 	 					,"vis_9F"=>"memo","vis_9W"=>30,
		//FAECES
		"vis_10"=>"Cons"			 	 				,"vis_10F"=>"memo","vis_10W"=>30,
		"vis_11"=>"Ingus"		 	 					,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Darah"		 	 					,"vis_12F"=>"memo","vis_12W"=>30,
		"vis_13"=>"Cacing"		 	 					,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Makanan"		 	 					,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Obat Obatan"	 	 					,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Observasi"	 	 					,"vis_16F"=>"memo","vis_16W"=>30,
		"vis_17"=>"Jam"	 	 							,"vis_17F"=>"memo","vis_17W"=>30,
		);	
		
$visit_ri_pengawasan_pasien_dewasa = array(
		//Observasi
		"vis_1"=>"Kesadaran" 							,"vis_1F"=>"edit","vis_1W"=>30,
		"vis_2"=>"Tensi"                				,"vis_2F"=>"memo","vis_2W"=>30,
		"vis_3"=>"Nadi"  								,"vis_3F"=>"memo","vis_3W"=>30,
		"vis_4"=>"Pernapasan"			  				,"vis_4F"=>"memo","vis_4W"=>30,
		"vis_5"=>"Suhu"									,"vis_5F"=>"memo","vis_5W"=>30,
		"vis_6"=>"CVP"		 			        		,"vis_6F"=>"memo","vis_6W"=>30,
		"vis_7"=>"Obat"				  					,"vis_7F"=>"memo","vis_7W"=>30,
		//keseimbangan cairan
		"vis_8"=>"Oral"	 	 							,"vis_8F"=>"memo","vis_8W"=>30,
		"vis_9"=>"Infus"		 	 					,"vis_9F"=>"memo","vis_9W"=>30,
		"vis_10"=>"Jumlah"			 	 				,"vis_10F"=>"memo","vis_10W"=>30,
		"vis_11"=>"Urin"		 	 					,"vis_11F"=>"memo","vis_11W"=>30,
		"vis_12"=>"Muntah"		 	 					,"vis_12F"=>"memo","vis_12W"=>30,
		"vis_13"=>"Draibage"		 	 				,"vis_13F"=>"memo","vis_13W"=>30,
		"vis_14"=>"Jumlah"		 	 					,"vis_14F"=>"memo","vis_14W"=>30,
		"vis_15"=>"Perawat"	 	 						,"vis_15F"=>"memo","vis_15W"=>30,
		"vis_16"=>"Tanggal"	 	 						,"vis_16F"=>"memo","vis_16W"=>30,
		"vis_17"=>"Jam"	 	 							,"vis_17F"=>"memo","vis_17W"=>30,
		
		);
		
$visit_ri_dokumen_surat_pengantar = array(
		"vis_1"=>"Isi Surat Pengantar" 					,"vis_1F"=>"edit","vis_1W"=>100,
		);	
		
$visit_ri_catatan_harian_perjalanan_penyakit = array(		
		"vis_1"=>"Jam"								, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Catatan Dokter"						, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Instruksi / Medikasi"					, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Yang Menerima Instruksi"				, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Dokter Pemberi Instruksi"				, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Tanggal"								, "vis_6F"=>"edit","vis_6W"=>50,
		);
		
$visit_ri_hasil_laboratorium = array(		
		"vis_1"=>"Hasil Laboratorium"					, "vis_1F"=>"edit","vis_1W"=>50,
		);

$visit_ri_hasil_radiologi = array(		
		"vis_1"=>"Hasil Radiologi"						, "vis_1F"=>"edit","vis_1W"=>50,
		);
		
$visit_ri_hasil_USG = array(		
		"vis_1"=>"Hasil Pemeriksaan USG"				, "vis_1F"=>"edit","vis_1W"=>50,
		);
		
$visit_ri_laporan_alat_pembedahan = array(		
		"vis_1"=>"Dosis"																				, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Spesialis Bedah"																		, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Instrumentator"																		, "vis_3F"=>"edit","vis_3W"=>50,
		//jenis infus
		"vis_4"=>"1.","vis_5"=>"2.","vis_6"=>"3.","vis_7"=>"4.","vis_8"=>"5."										,"vis_4F"=>"edit","vis_4W"=>30,
		//satuan
		"vis_9"=>"Satuan","vis_10"=>"Satuan","vis_11"=>"Satuan","vis_12"=>"Satuan","vis_13"=>"Satuan"									,"vis_9F"=>"edit","vis_9W"=>30,
		//jumlah
		"vis_14"=>"Jumlah","vis_15"=>"Jumlah","vis_16"=>"Jumlah","vis_17"=>"Jumlah","vis_18"=>"Jumlah"								,"vis_14F"=>"edit","vis_14W"=>30,
		//jenis obat-obatan
		"vis_19"=>"1.","vis_20"=>"2.","vis_21"=>"3.","vis_22"=>"4.","vis_23"=>"5."								,"vis_19F"=>"edit","vis_19W"=>30,
		//satuan
		"vis_24"=>"Satuan","vis_25"=>"Satuan","vis_26"=>"Satuan","vis_27"=>"Satuan","vis_28"=>"Satuan"								,"vis_24F"=>"edit","vis_24W"=>30,
		//jumlah
		"vis_29"=>"Jumlah","vis_30"=>"Jumlah","vis_31"=>"Jumlah","vis_32"=>"Jumlah","vis_33"=>"Jumlah"								,"vis_29F"=>"edit","vis_29W"=>30,
		//jenis alkes
		"vis_34"=>"1.","vis_35"=>"2.","vis_36"=>"3.","vis_37"=>"4.","vis_38"=>"5.","vis_39"=>"6.","vis_40"=>"7."		,"vis_34F"=>"edit","vis_34W"=>30,
		//satuan
		"vis_41"=>"Satuan","vis_42"=>"Satuan","vis_43"=>"Satuan","vis_44"=>"Satuan","vis_45"=>"Satuan","vis_46"=>"Satuan","vis_47"=>"Satuan"		,"vis_41F"=>"edit","vis_41W"=>30,
		//jumlah
		"vis_48"=>"Jumlah","vis_49"=>"Jumlah","vis_50"=>"Jumlah","vis_51"=>"Jumlah","vis_52"=>"Jumlah","vis_53"=>"Jumlah","vis_54"=>"Jumlah"		,"vis_48F"=>"edit","vis_48W"=>30,
		"vis_55"=>"Alat Yang Ditinggalkan Pada Pasien"													, "vis_55F"=>"edit","vis_55W"=>50,
		"vis_56"=>"Jenis Tindakan"													, "vis_55F"=>"edit","vis_55W"=>50,
		);	
		
$visit_ri_grafik_suhu = array(		
		"vis_1"=>"Diagnosis"								, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Tanggal"									, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Jam"										, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Pernafasan"								, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Nadi"										, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Suhu"										, "vis_6F"=>"edit","vis_6W"=>50,
		//obat-obatan dll
		"vis_7"=>"Obat-Obatan"								, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"&deg;"										, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"&deg;"										, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"&deg;"										, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"&deg;"										, "vis_11F"=>"edit","vis_11W"=>50,
		"vis_12"=>"&deg;"										, "vis_12F"=>"edit","vis_12W"=>50,
		"vis_13"=>"&deg;"										, "vis_13F"=>"edit","vis_13W"=>50,
		"vis_14"=>"Diet"									, "vis_14F"=>"edit","vis_14W"=>50,
		"vis_15"=>"Spuntum"									, "vis_15F"=>"edit","vis_15W"=>50,
		"vis_16"=>"Darah"									, "vis_16F"=>"edit","vis_16W"=>50,
		"vis_17"=>"&deg;"									, "vis_17F"=>"edit","vis_17W"=>50,
		"vis_18"=>"&deg;"									, "vis_18F"=>"edit","vis_18W"=>50,
		"vis_19"=>"&deg;"									, "vis_196F"=>"edit","vis_19W"=>50,
		"vis_20"=>"Urine"									, "vis_20F"=>"edit","vis_20W"=>50,
		"vis_21"=>"Faeces"									, "vis_21F"=>"edit","vis_21W"=>50,
		"vis_22"=>"Muntah"									, "vis_22F"=>"edit","vis_22W"=>50,
		"vis_23"=>"Tensi Systole"								, "vis_23F"=>"edit","vis_23W"=>50,
		"vis_24"=>"Tensi Dyastole"								, "vis_24F"=>"edit","vis_24W"=>50,
		"vis_25"=>"Berat Badan"								, "vis_25F"=>"edit","vis_25W"=>50,
		"vis_26"=>"Tindakan Khusus"							, "vis_26F"=>"edit","vis_26W"=>50,
//tambahan hr
		//di bwh obat-obatan dll
		"vis_27"=>"&nbsp;"									, "vis_27F"=>"edit","vis_27W"=>50,
		"vis_28"=>"&nbsp;"									, "vis_28F"=>"edit","vis_28W"=>50,
		"vis_29"=>"&nbsp;"									, "vis_29F"=>"edit","vis_29W"=>50,
		"vis_30"=>"&nbsp;"									, "vis_30F"=>"edit","vis_30W"=>50,
		"vis_31"=>"&nbsp;"									, "vis_31F"=>"edit","vis_31W"=>50,
		"vis_32"=>"&nbsp;"									, "vis_32F"=>"edit","vis_32W"=>50,
		//uraian dibwh darah
		"vis_33"=>"&nbsp;"									, "vis_33F"=>"edit","vis_33W"=>50,
		"vis_34"=>"&nbsp;"									, "vis_34F"=>"edit","vis_34W"=>50,
		"vis_35"=>"&nbsp;"									, "vis_35F"=>"edit","vis_35W"=>50,
		//tambahan 21-10-07		
		//"vis_36"=>"Tekanan Darah"							, "vis_36F"=>"edit","vis_36W"=>50,
		);

$visit_ri_grafik_ibu = array(		
		"vis_1"=>"Diagnosis"								, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Tanggal"									, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Jam"										, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Pernafasan"								, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Nadi"										, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Suhu"										, "vis_6F"=>"edit","vis_6W"=>50,
		//medikasi
		"vis_7"=>"&deg;"									, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"&deg;"									, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"&deg;"									, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"&deg;"									, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"&deg;"									, "vis_11F"=>"edit","vis_11W"=>50,
		//dosis
		"vis_12"=>"&deg;"									, "vis_12F"=>"edit","vis_12W"=>50,
		"vis_13"=>"&deg;"									, "vis_13F"=>"edit","vis_13W"=>50,
		"vis_14"=>"&deg;"									, "vis_14F"=>"edit","vis_14W"=>50,
		"vis_15"=>"&deg;"									, "vis_15F"=>"edit","vis_15W"=>50,
		"vis_16"=>"&deg;"									, "vis_16F"=>"edit","vis_16W"=>50,
		"vis_17"=>"Keadaan Umum"							, "vis_17F"=>"edit","vis_17W"=>50,
		"vis_18"=>"Perut"									, "vis_18F"=>"edit","vis_18W"=>50,
		"vis_19"=>"Buah Dada/Laktasi"						, "vis_19F"=>"edit","vis_19W"=>50,
		"vis_20"=>"Luka Pembedahan"							, "vis_20F"=>"edit","vis_20W"=>50,
		"vis_21"=>"Fundus Uteri"							, "vis_21F"=>"edit","vis_21W"=>50,
		"vis_22"=>"Kontraksi"								, "vis_22F"=>"edit","vis_22W"=>50,
		"vis_23"=>"Perinium"								, "vis_23F"=>"edit","vis_23W"=>50,
		"vis_24"=>"Lochia"									, "vis_24F"=>"edit","vis_24W"=>50,
		"vis_25"=>"Flatus"									, "vis_25F"=>"edit","vis_25W"=>50,
		"vis_26"=>"Miksi"									, "vis_26F"=>"edit","vis_26W"=>50,
		"vis_27"=>"Defakasi"								, "vis_27F"=>"edit","vis_27W"=>50,
		//Darah
		"vis_28"=>"&deg;"									, "vis_28F"=>"edit","vis_28W"=>50,
		"vis_29"=>"&deg;"									, "vis_29F"=>"edit","vis_29W"=>50,
		"vis_30"=>"&deg;"									, "vis_30F"=>"edit","vis_30W"=>50,
		"vis_31"=>"&deg;"									, "vis_31F"=>"edit","vis_31W"=>50,
		"vis_32"=>"&deg;"									, "vis_32F"=>"edit","vis_32W"=>50,
		"vis_33"=>"Muntah"									, "vis_33F"=>"edit","vis_33W"=>50,
		"vis_34"=>"Tensi Sys"								, "vis_34F"=>"edit","vis_34W"=>50,
		"vis_35"=>"Tensi Dyas"								, "vis_35F"=>"edit","vis_35W"=>50,
		"vis_36"=>"Berat Badan"								, "vis_36F"=>"edit","vis_36W"=>50,
		"vis_37"=>"Tindakan Khusus"							, "vis_37F"=>"edit","vis_37W"=>50,
// tambahan hr		
		"vis_38"=>"Darah"									, "vis_38F"=>"edit","vis_38W"=>50,
		//uraian dari  medikasi
		"vis_39"=>"&nbsp;"									, "vis_39F"=>"edit","vis_39W"=>50,
		"vis_40"=>"&nbsp;"									, "vis_40F"=>"edit","vis_40W"=>50,
		"vis_41"=>"&nbsp;"									, "vis_41F"=>"edit","vis_41W"=>50,
		"vis_42"=>"&nbsp;"									, "vis_42F"=>"edit","vis_42W"=>50,
		"vis_43"=>"&nbsp;"									, "vis_43F"=>"edit","vis_43W"=>50,
		//uraian dari Dosis
		"vis_44"=>"&nbsp;"									, "vis_44F"=>"edit","vis_44W"=>50,
		"vis_45"=>"&nbsp;"									, "vis_45F"=>"edit","vis_45W"=>50,
		"vis_46"=>"&nbsp;"									, "vis_46F"=>"edit","vis_46W"=>50,
		"vis_47"=>"&nbsp;"									, "vis_47F"=>"edit","vis_47W"=>50,
		"vis_48"=>"&nbsp;"									, "vis_48F"=>"edit","vis_48W"=>50,
		//Lain-lain dibawah darah
		"vis_49"=>"&nbsp;"									, "vis_49F"=>"edit","vis_49W"=>50,
		"vis_50"=>"&nbsp;"									, "vis_50F"=>"edit","vis_50W"=>50,
		"vis_51"=>"&nbsp;"									, "vis_51F"=>"edit","vis_51W"=>50,
		"vis_52"=>"&nbsp;"									, "vis_52F"=>"edit","vis_52W"=>50,
		"vis_53"=>"&nbsp;"									, "vis_53F"=>"edit","vis_53W"=>50,
//tambahan 21-10-07		
		//"vis_54"=>"Tekanan Darah"							, "vis_54F"=>"edit","vis_54W"=>50,
		);

$visit_ri_grafik_bayi = array(		
		"vis_1"=>"Dokter"									, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Tanggal"									, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Jam"										, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Berat Badan"								, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Suhu"										, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Makanan/Minuman"							, "vis_6F"=>"edit","vis_6W"=>50,
		"vis_7"=>"Defakasi"									, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"Miksi"									, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"Tidur"									, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"Tangis"									, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"Nafas"									, "vis_11F"=>"edit","vis_11W"=>50,
		//catatan
		"vis_12"=>"&deg;"									, "vis_12F"=>"edit","vis_12W"=>50,
		"vis_13"=>"&deg;"									, "vis_13F"=>"edit","vis_13W"=>50,
		"vis_14"=>"&deg;"									, "vis_14F"=>"edit","vis_14W"=>50,
		"vis_15"=>"&deg;"									, "vis_15F"=>"edit","vis_15W"=>50,
		"vis_16"=>"Tindakan Khusus"							, "vis_16F"=>"edit","vis_16W"=>50,
//tambahan hr
		//uraian dari catatan (obat2an)		
		"vis_17"=>"&nbsp;"									, "vis_17F"=>"edit","vis_17W"=>50,
		"vis_18"=>"&nbsp;"									, "vis_18F"=>"edit","vis_18W"=>50,
		"vis_19"=>"&nbsp;"									, "vis_19F"=>"edit","vis_19W"=>50,
		"vis_20"=>"&nbsp;"									, "vis_20F"=>"edit","vis_20W"=>50,
		"vis_21"=>"Dokter"									, "vis_21F"=>"edit","vis_21W"=>50,
		"vis_22"=>"Ruangan"									, "vis_22F"=>"edit","vis_22W"=>50,
//tambahan 21-10-07		
		//"vis_23"=>"Tekanan Darah"							, "vis_23F"=>"edit","vis_23W"=>50,
		
		);
			
$visit_ri_laporan_anesthesia = array(		
		"vis_1"=>"Dokter Anestesiologi"						, "vis_1F"=>"edit","vis_1W"=>50,
		"vis_2"=>"Penata Anestesia"							, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Ahli Bedah"								, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Diagnosa Preoperasi"						, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"Diagnosa Postoperasi"						, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Tindakan Operasi"							, "vis_6F"=>"edit","vis_6W"=>50,
		"vis_7"=>"Jenis Anestesia"							, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"Status Fisik"								, "vis_8F"=>"edit","vis_8W"=>50,
		//keadaan preoperasi
		"vis_9"=>"Komplikasi Pre Op"						, "vis_9F"=>"edit","vis_9W"=>50,
		"vis_10"=>"Berat Badan"								, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"Tensi"									, "vis_11F"=>"edit","vis_11W"=>50,
		"vis_12"=>"Nadi"									, "vis_12F"=>"edit","vis_12W"=>50,
		"vis_13"=>"Respirasi"								, "vis_13F"=>"edit","vis_13W"=>50,
		"vis_14"=>"Suhu"									, "vis_14F"=>"edit","vis_14W"=>50,
		"vis_15"=>"Golongan Darah"							, "vis_15F"=>"edit","vis_15W"=>50,
		"vis_16"=>"HB"										, "vis_16F"=>"edit","vis_16W"=>50,
		"vis_17"=>"Leukosit"								, "vis_17F"=>"edit","vis_17W"=>50,
		//premidikasi
		"vis_18"=>"Pemberian"								, "vis_18F"=>"edit","vis_18W"=>50,
		"vis_19"=>"Hasil"									, "vis_19F"=>"edit","vis_19W"=>50,
		//Medikasi
		"vis_20"=>"1","vis_21"=>"2","vis_22"=>"3","vis_23"=>"4"		, "vis_20F"=>"edit","vis_20W"=>50,
		"vis_24"=>"5","vis_25"=>"6","vis_26"=>"7","vis_27"=>"8"		, "vis_24F"=>"edit","vis_24W"=>50,
		"vis_28"=>"9","vis_29"=>"10","vis_30"=>"11","vis_31"=>"12"	, "vis_28F"=>"edit","vis_28W"=>50,
		"vis_32"=>"13","vis_33"=>"14","vis_34"=>"15"				, "vis_32F"=>"edit","vis_32W"=>50,
		//posisi
		"vis_35"=>"Posisi"									, "vis_35F"=>"edit","vis_35W"=>50,
		//pemb.cairan
		"vis_36"=>"RL","vis_37"=>"NaCL","vis_38"=>"Dec"		, "vis_38F"=>"edit","vis_38W"=>50,
		"vis_39"=>"Waktu"									, "vis_39F"=>"edit","vis_39W"=>50,
		"vis_40"=>"Tanggal"									, "vis_40F"=>"edit","vis_40W"=>50,
		"vis_41"=>"O2"										, "vis_41F"=>"edit","vis_41W"=>50,
		"vis_42"=>"N2O"										, "vis_42F"=>"edit","vis_42W"=>50,
		"vis_43"=>"Infus"									, "vis_43F"=>"edit","vis_43W"=>50,
		"vis_44"=>"Respirasi"								, "vis_44F"=>"edit","vis_44W"=>50,
		"vis_45"=>"Nadi"									, "vis_45F"=>"edit","vis_45W"=>50,
		"vis_46"=>"Tensi"									, "vis_46F"=>"edit","vis_46W"=>50,
		"vis_47"=>"Pendarahan"								, "vis_47F"=>"edit","vis_47W"=>50,
		"vis_48"=>"Urine"									, "vis_48F"=>"edit","vis_48W"=>50,
		//keadaan post operasi
		"vis_49"=>"Tekanan Darah"							, "vis_49F"=>"edit","vis_49W"=>50,
		"vis_50"=>"Nadi"									, "vis_50F"=>"edit","vis_50W"=>50,
		"vis_51"=>"Respirasi"								, "vis_51F"=>"edit","vis_51W"=>50,
		"vis_52"=>"Replex"									, "vis_52F"=>"edit","vis_52W"=>50,
		"vis_53"=>"Muntah"									, "vis_53F"=>"edit","vis_53W"=>50,
		"vis_54"=>"Gelisah"									, "vis_54F"=>"edit","vis_54W"=>50,
		"vis_55"=>"Bangun"									, "vis_55F"=>"edit","vis_55W"=>50,
		"vis_56"=>"Stadia Operasi"							, "vis_56F"=>"edit","vis_56W"=>50,
		//PEMAKAIAN OBAT/BAHAN/ALAT
		//Obat Suntik
		"vis_57"=>"Sod Thoipentoce"							, "vis_57F"=>"edit","vis_57W"=>50,
		"vis_58"=>"Ketamin HCL"								, "vis_58F"=>"edit","vis_58W"=>50,
		"vis_59"=>"Succ Siccum"								, "vis_59F"=>"edit","vis_59W"=>50,
		"vis_60"=>"Pancuronium Br"							, "vis_60F"=>"edit","vis_60W"=>50,
		"vis_61"=>"Quclicin"								, "vis_61F"=>"edit","vis_61W"=>50,
		"vis_62"=>"Atropin"									, "vis_62F"=>"edit","vis_62W"=>50,
		"vis_63"=>"Neusigmin"								, "vis_63F"=>"edit","vis_63W"=>50,
		"vis_64"=>"Bupival Hcl 0.5%"						, "vis_64F"=>"edit","vis_64W"=>50,
		"vis_65"=>"Lidovain Hcl"							, "vis_65F"=>"edit","vis_65W"=>50,
		"vis_66"=>"Dropeno"									, "vis_66F"=>"edit","vis_66W"=>50,
		"vis_67"=>"Diazepam"								, "vis_67F"=>"edit","vis_67W"=>50,
		"vis_68"=>"Carbazochrom"							, "vis_68F"=>"edit","vis_68W"=>50,
		"vis_69"=>"Meperidim hel"							, "vis_69F"=>"edit","vis_69W"=>50,
		//obat inhalasi
		"vis_70"=>"Isoflorance"								, "vis_70F"=>"edit","vis_70W"=>50,
		"vis_71"=>"Hallothaen"								, "vis_71F"=>"edit","vis_71W"=>50,
		"vis_72"=>"Enflureance"								, "vis_72F"=>"edit","vis_72W"=>50,
		"vis_73"=>"N2O"										, "vis_73F"=>"edit","vis_73W"=>50,
		"vis_74"=>"Total"									, "vis_74F"=>"edit","vis_74W"=>50,
		"vis_75"=>"O2 Nesthesi"								, "vis_75F"=>"edit","vis_75W"=>50,
		"vis_76"=>"O2 Ventilator"							, "vis_76F"=>"edit","vis_76W"=>50,
		"vis_77"=>"Total"									, "vis_77F"=>"edit","vis_77W"=>50,
		"vis_78"=>"Ether"									, "vis_78F"=>"edit","vis_78W"=>50,
		//CAIRAN
		"vis_79"=>"NaCL"									, "vis_79F"=>"edit","vis_79W"=>50,
		"vis_80"=>"RL"										, "vis_80F"=>"edit","vis_80W"=>50,
		"vis_81"=>"D5%"										, "vis_81F"=>"edit","vis_81W"=>50,
		"vis_82"=>"NaCL Dex(2A)"							, "vis_82F"=>"edit","vis_82W"=>50,
		//ALAT LAIN-LAIN
		"vis_83"=>"Spuit Mantoux"							, "vis_83F"=>"edit","vis_83W"=>50,
		"vis_84"=>"Spuit 2,5 cc"							, "vis_84F"=>"edit","vis_84W"=>50,
		"vis_85"=>"Spuit 10 cc"								, "vis_85F"=>"edit","vis_85W"=>50,
		"vis_86"=>"Spuit 20 cc"								, "vis_86F"=>"edit","vis_86W"=>50,
		"vis_87"=>"Tranfusi Set"							, "vis_87F"=>"edit","vis_87W"=>50,
		"vis_88"=>"Infus Set"								, "vis_88F"=>"edit","vis_88W"=>50,
		"vis_89"=>"iv Catheter"								, "vis_89F"=>"edit","vis_89W"=>50,
		"vis_90"=>"Lain-Lain"								, "vis_90F"=>"edit","vis_90W"=>50,
		//RECOVERY ROOM
		"vis_91"=>"Petugas RR"								, "vis_91F"=>"edit","vis_91W"=>50,
		"vis_92"=>"Aktivitas Motorik Masuk"					, "vis_92F"=>"edit","vis_92W"=>50,
		"vis_93"=>"Aktivitas Motorik Keluar"				, "vis_93F"=>"edit","vis_93W"=>50,
		"vis_94"=>"Pernafasan Masuk"						, "vis_94F"=>"edit","vis_94W"=>50,
		"vis_95"=>"Pernafasan Keluar"						, "vis_95F"=>"edit","vis_95W"=>50,
		"vis_96"=>"Tensi Masuk"								, "vis_96F"=>"edit","vis_96W"=>50,
		"vis_97"=>"Tensi Keluar"							, "vis_97F"=>"edit","vis_97W"=>50,
		"vis_98"=>"Kesadaran Masuk"							, "vis_98F"=>"edit","vis_98W"=>50,
		"vis_99"=>"Kesadaran Keluar"						, "vis_99F"=>"edit","vis_99W"=>50,
		"vis_100"=>"Warna Kulit Masuk"						, "vis_100F"=>"edit","vis_100W"=>50,
		"vis_101"=>"Warna Kulit Keluar"						, "vis_101F"=>"edit","vis_101W"=>50,
		"vis_102"=>"Jumlah Masuk"							, "vis_102F"=>"edit","vis_102W"=>50,
		"vis_103"=>"Jumlah Keluar"							, "vis_103F"=>"edit","vis_103W"=>50,
		"vis_104"=>"Waktu Masuk"							, "vis_104F"=>"edit","vis_104W"=>50,
		"vis_105"=>"Waktu Keluar"							, "vis_105F"=>"edit","vis_105W"=>50,
		"vis_106"=>"Catatan Lain"							, "vis_106F"=>"edit","vis_106W"=>50,
		//PERINTAH RUANGAN
		"vis_107"=>"Kesakitan Diberi"						, "vis_107F"=>"edit","vis_107W"=>50,
		"vis_108"=>"Mual-Mual/Muntah Diberi"				, "vis_108F"=>"edit","vis_108W"=>50,
		"vis_109"=>"Program Cairan"							, "vis_109F"=>"edit","vis_109W"=>50,
		);
		
$visit_ri_pemakaian_alat_keperawatan = array(		
		"vis_1"=>"Tanggal"									, "vis_1F"=>"edit","vis_1W"=>50,
		//ALAT
		"vis_2"=>"Infus Set"								, "vis_2F"=>"edit","vis_2W"=>50,
		"vis_3"=>"Transfusi Set"							, "vis_3F"=>"edit","vis_3W"=>50,
		"vis_4"=>"Abocath"									, "vis_4F"=>"edit","vis_4W"=>50,
		"vis_5"=>"NaCl 0.9%"								, "vis_5F"=>"edit","vis_5W"=>50,
		"vis_6"=>"Dec 10%"									, "vis_6F"=>"edit","vis_6W"=>50,
		"vis_7"=>"R.L"										, "vis_7F"=>"edit","vis_7W"=>50,
		"vis_8"=>"2A"										, "vis_8F"=>"edit","vis_8W"=>50,
		"vis_9"=>"Transfusi"									, "vis_9F"=>"edit","vis_9W"=>50,
		//
		"vis_10"=>"Cateter"									, "vis_10F"=>"edit","vis_10W"=>50,
		"vis_11"=>"N G T"									, "vis_11F"=>"edit","vis_11W"=>50,
		"vis_12"=>"Shorten"									, "vis_12F"=>"edit","vis_12W"=>50,
		"vis_13"=>"O2 Set"									, "vis_13F"=>"edit","vis_13W"=>50,
		"vis_14"=>"Spuit (2,5;5;10;20)"						, "vis_14F"=>"edit","vis_14W"=>50,
		"vis_15"=>"Slymzuiger"								, "vis_15F"=>"edit","vis_15W"=>50,
		"vis_16"=>"Alkohol"									, "vis_16F"=>"edit","vis_16W"=>50,
		"vis_17"=>"Bethadin"								, "vis_17F"=>"edit","vis_17W"=>50,
		"vis_18"=>"Kaps"									, "vis_18F"=>"edit","vis_18W"=>50,
		"vis_19"=>"Khasa Steril"							, "vis_19F"=>"edit","vis_19W"=>50,
		"vis_20"=>"Verband"									, "vis_20F"=>"edit","vis_20W"=>50,
		"vis_21"=>"Elastis Verband"							, "vis_21F"=>"edit","vis_21W"=>50,
		"vis_22"=>"Elektoda + Monitor"						, "vis_22F"=>"edit","vis_22W"=>50,
		"vis_23"=>"Ventilator"								, "vis_23F"=>"edit","vis_23W"=>50,
		"vis_24"=>"EKG"										, "vis_24F"=>"edit","vis_24W"=>50,
		//TINDAKAN
		"vis_25"=>"Pasang Transfusi"						, "vis_25F"=>"edit","vis_25W"=>50,
		"vis_26"=>"Pasang Infus"							, "vis_26F"=>"edit","vis_26W"=>50,
		"vis_27"=>"Pasang Cateter"							, "vis_27F"=>"edit","vis_27W"=>50,
		"vis_28"=>"Pasang NGT"								, "vis_28F"=>"edit","vis_28W"=>50,
		"vis_29"=>"Pasang Shorteen"							, "vis_29F"=>"edit","vis_29W"=>50,
		"vis_30"=>"Pasang O2"								, "vis_30F"=>"edit","vis_30W"=>50,
		"vis_31"=>"Slymzuiger"								, "vis_31F"=>"edit","vis_31W"=>50,
		"vis_32"=>"Huknah"									, "vis_32F"=>"edit","vis_32W"=>50,
		"vis_33"=>"Ganti Balutan"							, "vis_33F"=>"edit","vis_33W"=>50,
		//INJECTIE
		"vis_34"=>"Intra Cutan"								, "vis_34F"=>"edit","vis_34W"=>50,
		"vis_35"=>"Sub Cutan"								, "vis_35F"=>"edit","vis_35W"=>50,
		"vis_36"=>"Intra Muscular"							, "vis_36F"=>"edit","vis_36W"=>50,
		"vis_37"=>"Intra Venous"							, "vis_37F"=>"edit","vis_37W"=>50,
		//
		"vis_38"=>"Vena Punctie"							, "vis_38F"=>"edit","vis_38W"=>50,
		"vis_39"=>"Lumbal Punctie"							, "vis_39F"=>"edit","vis_39W"=>50,
		"vis_40"=>"Pleura Punctie"							, "vis_40F"=>"edit","vis_40W"=>50,
		"vis_41"=>"Asites Punctie"							, "vis_41F"=>"edit","vis_41W"=>50,
		"vis_42"=>"BMP"										, "vis_42F"=>"edit","vis_42W"=>50,
		"vis_43"=>"EKG"										, "vis_43F"=>"edit","vis_43W"=>50,
		"vis_44"=>"Pasang Ventilator"						, "vis_44F"=>"edit","vis_44W"=>50,
		"vis_45"=>"Vena Sectie"								, "vis_45F"=>"edit","vis_45W"=>50,
		"vis_46"=>"Bilas Lambung"							, "vis_46F"=>"edit","vis_46W"=>50,
		"vis_47"=>"Spuling"									, "vis_47F"=>"edit","vis_47W"=>50,
	//tambahan untuk item alat	
		"vis_48"=>"Fday Cath"								, "vis_48F"=>"edit","vis_48W"=>50,
		"vis_49"=>"Urine Bag"								, "vis_49F"=>"edit","vis_49W"=>50,
	//tambahan untuk item tindakan	
		"vis_50"=>"ECT"										, "vis_50F"=>"edit","vis_50W"=>50,
		"vis_51"=>"Fiksasi/Tindakan Isolasi"				, "vis_51F"=>"edit","vis_51W"=>50,
		);
?>
