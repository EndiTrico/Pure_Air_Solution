<style>

</style>

<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="admin_dashboard.php">
			<span class="align-middle">Pure Air Solutions</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">
				Main
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_dashboard.php">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_profile.php">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="logout.php">
					<i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Log Out</span>
				</a>
			</li>

			<li class="sidebar-header">
				Entities
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_create.php">
					<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Create</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="admin_display_entities.php">
					<i class="align-middle" data-feather="book"></i> <span class="align-middle">Display and
						Modify</span>
				</a>
			</li>

			<li class="sidebar-header">
				Report
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="ui-buttons.html">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Buttons</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="ui-forms.html">
					<i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
				</a>
			</li>
			<!--
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
    const sidebarItems = document.querySelectorAll('.sidebar-item');

    let activeItem = null;

    const savedActiveItemIndex = localStorage.getItem('activeItemIndex');
    if (savedActiveItemIndex !== null) {
        sidebarItems[savedActiveItemIndex].classList.add('active');
        activeItem = sidebarItems[savedActiveItemIndex];
    }

    sidebarItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            if (activeItem !== null) {
                activeItem.classList.remove('active');
            }

            item.classList.add('active');

            activeItem = item;

            localStorage.setItem('activeItemIndex', index);
        });
    });
</script>