
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="LaborList.php"><i class="fa fa-list"></i>勤怠一覧</a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-circle-o"></i> <span>ユーザー別勤怠</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="UsersLaborList.php"><i class="fa fa-circle-o"></i>労務管理している従業員A</a></li>
                    <li><a href="UsersLaborList.php"><i class="fa fa-circle-o"></i>労務管理している従業員B</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>ユーザー情報を変更する</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="PasswordChange.php"><i class="fa fa-circle-o"></i>パスワードの変更</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i>
                    <span>マスタメンテナンス</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="EmployeeList.php"><i class="fa fa-circle-o"></i>従業員を検索する</a></li>
                    <li><a href="LaborAdministratorRegistration.php"><i class="fa fa-circle-o"></i>労務管理者の登録</a></li>
                    <li><a href="PersonInCharge.php"><i class="fa fa-circle-o"></i>労務管理者と従業員の紐付け</a></li>
                    <li><a href="Setting.php"><i class="fa fa-circle-o"></i>その他</a></li>
                </ul>
            </li>
            <?php if(isset($pageType)):?>
            <li class="active treeview menu-open">
                <a href="#">
                    <i class="fa fa-search"></i>
                    <span>検索する</span>
                </a>
            </li>
            <div class="sideVarSearchBox">
                <form action="#" method="post" class="sidebar-form">
                        <input type="date" name="date" class="form-control" placeholder="username">
                        <input type="text" name="username" class="form-control" placeholder="従業員名">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat pull-right">
                            検索<i class="fa fa-search"></i>
                        </button>
<!--
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
-->
                </form>
            </div>
            <?php endif;?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>