<nav class="pc-sidebar ">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="index.html" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="assets/images/logo.png" width="47px" alt="logo logo-xl">
                <img src="assets/images/logo.png" alt="" class="logo logo-sm">
                <span class="text-white font-weight-bold text-2xl">Si-NaMiRA</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>
                <li class="pc-item">
                    <a href="./" class="pc-link "><span class="pc-micon"><i data-feather="home"></i></span><span class="pc-mtext">Dashboard</span></a>
                </li>

                <?php
                //admin panel
                if ($level == 1 || $level == 2) {
                ?>

                    <li class="pc-item pc-caption">
                        <label>Data Master</label>
                    </li>
                    <li class="pc-item">
                        <a href="areaList" class="pc-link "><span class="pc-micon"><i data-feather="align-justify"></i></span><span class="pc-mtext">Master Area</span></a>
                    </li>
                    <li class="pc-item">
                        <a href="account" class="pc-link "><span class="pc-micon"><i data-feather="user"></i></span><span class="pc-mtext">Master Pengguna</span></a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Manajemen Program Kerja</label>
                    </li>
                    <li class="pc-item">
                        <a href="#" data-toggle="modal" data-target="#showYearProgram" class="pc-link "><span class="pc-micon"><i data-feather="server"></i></span><span class="pc-mtext">Data Program Kerja</span></a>
                    </li>
                    <li class="pc-item">
                        <a href="#" data-toggle="modal" data-target="#showYearActivity" class="pc-link "><span class="pc-micon"><i data-feather="bar-chart-2"></i></span><span class="pc-mtext">Data Kegiatan</span></a>
                    </li>
                <?php
                    //anggota panel
                } elseif ($level == 3) { ?>
                    <li class="pc-item pc-caption">
                        <label>Manajemen Program Kerja</label>
                    </li>
                    <li class="pc-item">
                        <a href="#" data-toggle="modal" data-target="#showYearProgram" class="pc-link "><span class="pc-micon"><i data-feather="server"></i></span><span class="pc-mtext">Data Program Kerja</span></a>
                    </li>
                    <li class="pc-item">
                        <a href="#" data-toggle="modal" data-target="#showYearActivity" class="pc-link "><span class="pc-micon"><i data-feather="bar-chart-2"></i></span><span class="pc-mtext">Data Kegiatan</span></a>
                    </li>
                <?php } ?>

            </ul>
        </div>

    </div>

</nav>

<div class="modal fade" id="showYearProgram" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="load-show-year-program" style="display: none;">
                <div class="modal-body">
                    <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                    loading......
                </div>
            </div>
            <div class="show-year-program" id="show-year-program"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="showYearActivity" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleEditModal" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="load-show-year-activity" style="display: none;">
                <div class="modal-body">
                    <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
                    loading......
                </div>
            </div>
            <div class="show-year-activity" id="show-year-activity"></div>
        </div>
    </div>
</div>