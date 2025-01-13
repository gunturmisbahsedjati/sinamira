<?php
include './inc/inc.library.php'
?>
<header class="pc-header ">
    <div class="header-wrapper">
        <!-- <div class="mr-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <div class="dropdown-menu pc-h-dropdown">
                        <a href="#!" class="dropdown-item">
                            <i data-feather="user"></i>
                            <span>My Account</span>
                        </a>
                        <div class="pc-level-menu">
                            <a href="#!" class="dropdown-item">
                                <i data-feather="menu"></i>
                                <span class="float-right"><i data-feather="chevron-right" class="mr-0"></i></span>
                                <span>Level2.1</span>
                            </a>
                            <div class="dropdown-menu pc-h-dropdown">
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>My Account</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Support</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Lock Screen</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                        <a href="#!" class="dropdown-item">
                            <i data-feather="settings"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i data-feather="life-buoy"></i>
                            <span>Support</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i data-feather="lock"></i>
                            <span>Lock Screen</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i data-feather="power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div> -->
        <div class="ml-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="assets/images/user/undraw_female-avatar_7t6k.svg" alt="user-image" class="user-avtar border border-secondary">
                        <span>
                            <span class="user-name"><?= $nama_akun ?></span>
                            <span class="user-desc">Administrator</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                        <a href="#!" class="dropdown-item" data-toggle="modal" data-target="#changePass" data-url="<?= encrypt(getUrlNow()); ?>">
                            <i data-feather="user"></i>
                            <span>Ganti Kata Sandi</span>
                        </a>
                        <a href="#!" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                            <i data-feather="power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>

    </div>

    <!-- modal -->
</header>
<div class="modal fade" id="changePass" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-modal="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div id="load-change-pass" style="display: none;">
                <div class="modal-body">
                    <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                    loading......
                </div>
            </div>
            <div class="change-pass" id="change-pass"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin akan Keluar ?</h5>
            </div>
            <div class="modal-body">Pilih "Keluar" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success" href="logout">Keluar</a>
            </div>
        </div>
    </div>
</div>