<?php session_start();
ini_set( 'display_errors', 1 );

class_exists('lib\Entity\User') or require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Entity/User.php';

use lib\Entity\User as User;
/** loginユーザの情報を取得*/
$loginUser = new User($_SESSION["UserId"]);
$loginUserName = $loginUser->getUserName();
?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="LogList.php">PcLogTool</a>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-right navbar-user">
											<li><a href="LogList.php"><i class="fa fa-bullseye"></i> Dashboard</a></li>
						<li><a href="htdocs/DailyGraph.php"><i class="fa fa-tasks"></i> DailyGraph</a></li>
						<li><a href="htdocs/MonthGraph.php"><i class="fa fa-tasks"></i> MonthGraph</a></li>
						 <li class="dropdown user-dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $loginUser->getUserName();?><b class="caret"></b></a>
								<ul class="dropdown-menu">
										<li><a href="Logout.php"><i class="fa fa-power-off"></i>ログアウト</a></li>
								</ul>
						</li>
				</ul>
		</div>
</nav>