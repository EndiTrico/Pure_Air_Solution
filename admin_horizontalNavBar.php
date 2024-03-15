<?php
include 'nameInitials.php';
$email = $_SESSION['email'];

?>

<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="" data-bs-toggle="dropdown">
                    <div style="width: 40px;
                                height: 40px;
                                border-radius: 50%; 
                                background-color: #222e3c; 
                                color: #fff; 
                                display: inline-flex;
                                justify-content: center;
                                align-items: center;
                                font-size: 17px;
                                font-weight: bold;" class="avatar img-fluid me-1 avatar-circle">
                        <?php echo initials(); ?>
                    </div> <span class="text-dark card-title" style="font-weight: bold; color:black !important;">
                        <?php echo fullName(); ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="admin_profile.php"><i class="align-middle me-1" data-feather="user"></i>Profilo</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" onclick="confirmDelete('<?php echo $email; ?>')" href="#">
                        <i class="align-middle me-1" data-feather="user-x"></i>Eliminare
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="align-middle me-1" data-feather="log-out"></i>Disconnettersi</a>
                </div>
            </li>
        </ul>
    </div>

</nav>

<script>
    function confirmDelete(email) {
        Swal.fire({
            title: "Are You Sure?",
            text: "Yout account will be set to inactive",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Action performed successfully",
                    icon: "success",
                    showConfirmButton: false
                });
                setTimeout(function() {
                    var url = 'delete_myself.php?email=' + encodeURIComponent(email);
                    window.location.href = url;
                }, 2000);
            }
        });
    }
</script>