<?php

if ($showFileKegiatan['file_surat_undangan'] != '' && $showFileKegiatan['file_sk_kegiatan'] != 0) {
    $fileSU = '<span class="text-success">Sudah unggah</span>';
    $checkSU = '';
    $disabledSU = '';
} elseif ($showFileKegiatan['file_surat_undangan'] == 0) {
    $fileSU = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkSU = 'checked';
    $disabledSU = 'disabled';
} else {
    $fileSU = '<span class="text-danger">Belum unggah</span>';
    $checkSU = '';
    $disabledSU = '';
}

if ($showFileKegiatan['file_sk_kegiatan'] != '' && $showFileKegiatan['file_sk_kegiatan'] != 0) {
    $fileSK = '<span class="text-success">Sudah unggah</span>';
    $checkSK = '';
    $disabledSK = '';
} elseif ($showFileKegiatan['file_sk_kegiatan'] == 0) {
    $fileSK = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkSK = 'checked';
    $disabledSK = 'disabled';
} else {
    $fileSK = '<span class="text-danger">Belum unggah</span>';
    $checkSK = '';
    $disabledSK = '';
}

if ($showFileKegiatan['file_panduan'] != '' && $showFileKegiatan['file_panduan'] != 0) {
    $filePanduan = '<span class="text-success">Sudah unggah</span>';
    $checkPanduan = '';
    $disabledPanduan = '';
} elseif ($showFileKegiatan['file_panduan'] == 0) {
    $filePanduan = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkPanduan = 'checked';
    $disabledPanduan = 'disabled';
} else {
    $filePanduan = '<span class="text-danger">Belum unggah</span>';
    $checkPanduan = '';
    $disabledPanduan = '';
}

if ($showFileKegiatan['file_surat_tugas'] != '' && $showFileKegiatan['file_surat_tugas'] != 0) {
    $fileST = '<span class="text-success">Sudah unggah</span>';
    $checkST = '';
    $disabledST = '';
} elseif ($showFileKegiatan['file_surat_tugas'] == 0) {
    $fileST = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkST = 'checked';
    $disabledST = 'disabled';
} else {
    $fileST = '<span class="text-danger">Belum unggah</span>';
    $checkST = '';
    $disabledST = '';
}

if ($showFileKegiatan['file_daftar_hadir'] != '' && $showFileKegiatan['file_daftar_hadir'] != 0) {
    $fileDH = '<span class="text-success">Sudah unggah</span>';
    $checkDH = '';
    $disabledDH = '';
} elseif ($showFileKegiatan['file_daftar_hadir'] == 0) {
    $fileDH = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkDH = 'checked';
    $disabledDH = 'disabled';
} else {
    $fileDH = '<span class="text-danger">Belum unggah</span>';
    $checkDH = '';
    $disabledDH = '';
}

if ($showFileKegiatan['file_notula'] != '' && $showFileKegiatan['file_notula'] != 0) {
    $fileNotula = '<span class="text-success">Sudah unggah</span>';
    $checkNotula = '';
    $disabledNotula = '';
} elseif ($showFileKegiatan['file_notula'] == 0) {
    $fileNotula = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkNotula = 'checked';
    $disabledNotula = 'disabled';
} else {
    $fileNotula = '<span class="text-danger">Belum unggah</span>';
    $checkNotula = '';
    $disabledNotula = '';
}

if ($showFileKegiatan['file_hasil_kegiatan'] != '' && $showFileKegiatan['file_hasil_kegiatan'] != 0) {
    $fileHK = '<span class="text-success">Sudah unggah</span>';
    $checkHK = '';
    $disabledHK = '';
} elseif ($showFileKegiatan['file_hasil_kegiatan'] == 0) {
    $fileHK = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkHK = 'checked';
    $disabledHK = 'disabled';
} else {
    $fileHK = '<span class="text-danger">Belum unggah</span>';
    $checkHK = '';
    $disabledHK = '';
}

if ($showFileKegiatan['file_dokumentasi'] != '' && $showFileKegiatan['file_dokumentasi'] != 0) {
    $fileDok = '<span class="text-success">Sudah unggah</span>';
    $checkDok = '';
    $disabledDok = '';
} elseif ($showFileKegiatan['file_dokumentasi'] == 0) {
    $fileDok = '<span class="text-secondary">Tidak perlu unggah</span>';
    $checkDok = 'checked';
    $disabledDok = 'disabled';
} else {
    $fileDok = '<span class="text-danger">Belum unggah</span>';
    $checkDok = '';
    $disabledDok = '';
}
