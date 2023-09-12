<div class="app-navbar-wrap" id="NavBarMain">
    <div class="app-navbar-topbar-mobile">
        <span class="app-navbar-toggler" data-win-toggle="navbar-left" data-win-target="#NavBarMain"></span>
        <div style="display: flex; justify-content: space-between; width: calc(100% - 60px);">
            <span class="app-navbar-name"><?= config('app_name'); ?></span>
            <span class="app-navbar-name">Home</span>
        </div>
    </div>
    <nav class="app-navbar">
        <div class="app-navbar-header">
            <span class="app-navbar-toggler" data-win-toggle="navbar-left" data-win-target="#NavBarMain" aria-controls="NavBarMain" aria-label="Toggle navigation"></span>
            <span class="app-navbar-name">RoborosX IoT</span>
        </div>
        <ul class="app-navbar-list" id="app-navbar-list">
            <li class="app-navbar-list-item">
                <a href="<?= url('dashboard.php')?>" class="">
                    <img src="assets/icons/logo.jpg" height="15%" width="15%">
                    <span>Home</span>
                </a>
            </li>
            <li class="app-navbar-list-item">
                        <a exact="true" href="<?= url('MyProjects.php'); ?>">
                            <i class="icons10-gauge"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li class="app-navbar-list-item">
                        <a exact="true" href="editor.php">
                            <i class="icons10-parallel-tasks"></i>
                            <span>OTA UPDATE</span>
                        </a>
                    </li>
                  
            <li class="app-navbar-list-item"><a target="_blank" href="https://roborosx.com" class="undefined" class="app-btn" type="button" data-win-toggle="modal" data-win-target="#MyDialog">
                    <i class="icons10-upload"></i>
                    <span>New Updates</span>
                </a></li>

            <li class="app-navbar-list-item"><a href="<?= url('logout.php') ?>" onclick="return confirm('Are you sure to logout ??')" class="undefined">
                    <i class="icons10-key"></i>
                    <span>Logout</span>
                </a>

            </li>

        </ul>
    </nav>
</div>
<div class="app-page-container has-padding">