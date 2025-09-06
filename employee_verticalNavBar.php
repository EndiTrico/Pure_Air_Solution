<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href = "client_dashboard.php">
			<span class="align-middle">Pure Air Solutions</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">
				Main
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="employee_dashboard.php">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="employee_profile.php">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Profilo</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="logout.php">
					<i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Disconnettersi</span>
				</a>
			</li>

			<li class="sidebar-header">
			Attività
			</li>
<!--
			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_create.php">
					<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Create</span>
				</a>
			</li>
-->
			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_create_job.php">
					<i class="align-middle" data-feather="book"></i> <span class="align-middle">Registro dei Lavori</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="employee_display_entities.php">
					<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Il Miei Attiviti</span>
				</a>
			</li>

			<!--<li class="sidebar-item">
				<a class="sidebar-link" href="ui-forms.html">
					<i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
				</a>
			</li>
			
					<li class="sidebar-item">
						<a class="sidebar-link" href="ui-cards.html">
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="ui-typography.html">
							<i class="align-middle" data-feather="align-left"></i> <span
								class="align-middle">Typography</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="icons-feather.html">
							<i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
						</a>
					</li>

					<li class="sidebar-header">
						Plugins & Addons
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="charts-chartjs.html">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span
								class="align-middle">Charts</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="maps-google.html">
							<i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
						</a>
					</li>-->
		</ul>
	</div>
</nav>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarItems = document.querySelectorAll('.sidebar-item');

  if (!localStorage.getItem('lastSelectedLink')) {
        if (sidebarItems.length > 0) {
            sidebarItems[0].classList.add('active');
            const firstLink = sidebarItems[0].querySelector('.sidebar-link').getAttribute('href');
            localStorage.setItem('lastSelectedLink', firstLink);
        }
    } else {
        const lastSelectedLink = localStorage.getItem('lastSelectedLink');

        sidebarItems.forEach(item => {
            const link = item.querySelector('.sidebar-link');
            const href = link.getAttribute('href');

            if (href === lastSelectedLink) {
                item.classList.add('active');
            }
        });

    }

    sidebarItems.forEach(item => {
        const link = item.querySelector('.sidebar-link');

        link.addEventListener('click', () => {
            sidebarItems.forEach(otherItem => {
                otherItem.classList.remove('active');
            });

            item.classList.add('active');

            localStorage.setItem('lastSelectedLink', link.getAttribute('href'));
        });
    });
});
</script>