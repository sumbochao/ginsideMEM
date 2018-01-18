<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd " />
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>GAME INSIDE</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta charset="utf-8" />
        <meta name="description" content="mecorp" />
        <meta name="keywords" content="mecorp" />
        <meta name="author" content="ME CORPORATION" />
        <meta name="copyright" content="Copyright ME 2012" />
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!--Mobile first-->
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0"/>-->

        <!--IE Compatibility modes-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="msapplication-TileColor" content="#5bc0de"/>
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png"/>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.min.css') ?>" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/Font-Awesome/css/font-awesome.min.css') ?>" />

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />

        <link rel="stylesheet" href="<?php echo base_url('assets/css/timepicker.css') ?>" />

        <link rel="stylesheet" href="<?php echo base_url('assets/css/theme.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/uniform/themes/default/css/uniform.default.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/inputlimiter/jquery.inputlimiter.1.0.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/chosen/chosen.min.css') ?>" />       
        <?php
        if ($_GET['func'] != 'user_realtime' && $_GET['func'] != 'info_daily_realtime') {
            ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui-1.10.3/css/cupertino/jquery-ui-1.10.3.custom.min.css') ?>" />
        <?php } ?>

        <link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui-1.10.3/css/cupertino/jquery.dataTables.css') ?>" />



        <link rel="stylesheet" href="<?php echo base_url('assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/uniform/themes/default/css/uniform.default.min.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-fileupload.min.css') ?>"  />


        <link rel="stylesheet" href="<?php echo base_url('assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css') ?>"/>




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>
          <script src="assets/lib/html5shiv/html5shiv.js"></script>
                  <script src="<?php echo base_url('assets/lib/respond/respond.min.js') ?>"></script>
                <![endif]-->

        <!--Modernizr 3.0-->
        <!--<script src="<?php echo base_url('assets/lib/modernizr-build.min.js') ?>"></script>-->
        <?php
        if ($_GET['control'] == 'phongthan_filters' || $_GET['control'] == 'dealswp_pt' || $_GET['control'] == 'uocnguyen_bog' || $_GET['control'] == 'choilainhanqua_pt' || $_GET['control'] == 'popupcms' || $_GET['control'] == 'tienbao_gm' || $_GET['control'] == 'accumulation' || $_GET['control'] == 'sellhero' || $_GET['control'] == 'vip' || $_GET['control'] == 'purchase' || ($_GET['control'] == 'reports' && $_GET['func'] == 'user_realtime' || $_GET['func'] == 'info_daily_realtime' || $_GET['control'] == 'toppay' || $_GET['control'] == 'dealos_bog' || $_GET['control'] == 'listpack' || $_GET['control'] == 'quahotro' || $_GET['control'] == 'choilainhanqua_gm' || $_GET['control'] == 'onlinenhanqua_lg')) {
            ?>
            <script src="<?php echo base_url('assets/js/jquery-1.7.2.js') ?>" type="text/javascript"></script>
            <?php
        } else {
            ?>
            <script src="<?php echo base_url('assets/lib/jquery.min.js') ?>" type="text/javascript"></script>
            <?php
        }
        ?>
        <script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
        <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui-1.10.3/js/jquery-ui-1.10.3.custom.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui-timepicker-addon.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/lib/uniform/jquery.uniform.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.dataTables.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/permisssion.css') ?>"/>
        <script src="<?php echo base_url('assets/js/tablednd.js') ?>" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/menu.css') ?>" />
        <script src="<?php echo base_url('assets/js/menu.js') ?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.notfound').click(function () {
                    $(this).next().fadeToggle('slow');
                });
            });
            var baseUrl = '<?php echo APPLICATION_URL; ?>';
        </script>
        <style>
            .submenuleft{display: none;}
        </style>
        <link href="<?php echo base_url('assets/css/ddsmoothmenu.css'); ?>" rel="stylesheet" type="text/css" />      
        <?php
        $this->load->MeAPI_Library("Mobile_Detect");
        $Mobile_Detect = new Mobile_Detect();
        if ($Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()) {
            ?>
            <script type="text/javascript">
                $(function () {
                    var ww = document.body.clientWidth;
                    if (ww <= 900) {
                        $(".navmenu").addClass("classArrow");
                    }
                });
            </script>
            <script src="<?php echo base_url('assets/js/menu_reponsive.js'); ?>" type="text/javascript"></script>
            <?php
        }
        ?>
        <style>
            .fa-table {
                padding-right: 3px;
            }
        </style>
    </head>
    <body>
        <?php
        if ($_GET['iframe'] != 1) {
            ?>
            <div id="wrap">
                <?php if (!empty($session_account)): ?>
                    <div id="top">

                        <!-- .navbar -->
                        <nav class="navbar navbar-inverse navbar-static-top">

                            <!-- Brand and toggle get grouped for better mobile display -->
                            <header class="navbar-header">
                                <div class="toggleMenu navbar-toggle">
                                    <span class="overlay">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </div>
                                <a href="<?php echo base_url('?control=welcome&func=index'); ?>" class="navbar-brand">
                                    <img src="assets/img/logo.png" alt="Mecorp" height="50">
                                </a>
                            </header>
                            <div class="topnav">
                                <div class="btn-toolbar">

                                    <div class="btn-group">
                                        <a href="<?php echo base_url('?control=login&func=logout') ?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                                            <b><?php echo $session_account['fullname'] ? $session_account['fullname'] : $session_account['username']; ?> <i class="fa fa-power-off"></i></b>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /.topnav -->
                            <div class="collapse navbar-collapse navbar-ex1-collapse">

                                <!-- .nav -->
                                <!--
                                <ul class="nav navbar-nav">
                                    <li> <a href="dashboard.html">Dashboard</a> </li>
                                    <li> <a href="table.html">Tables</a> </li>
                                    <li> <a href="file.html">File Manager</a> </li>

                                </ul>
                                -->
                                <!-- /.nav -->

                            </div>
                        </nav><!-- /.navbar -->

                        <!-- header.head -->
                        <header class="head">
                            <div class="main-bar">
                                <h3>
                                    <!--<i class="fa fa-pencil"></i>-->
                                    <?php echo isset($session_menu['sub'][$_GET['control']]['title']) ? $session_menu['sub'][$_GET['control']]['title'] : strtoupper($_GET['func']) ?></h3>
                            </div><!-- /.main-bar -->
                        </header>

                        <!-- end header.head -->
                    </div><!-- /#top -->

                    <?php
                    $this->load->helper('recursive_helper');
                    $this->load->MeAPI_Model('MenuModel');
                    $this->load->MeAPI_Model('PermissionMenuModel');
                    $this->load->MeAPI_Library('Memcacher');

                    $tblModPer = new PermissionMenuModel();
                    $key = "module_user" . $_SESSION['account']['id'] . date("Ymd", time());
                    //$listModule = Memcacher::Get($key);
                    $listModule = false;
                    if ($listModule == false) {
                        $listModule = $tblModPer->moduleByUser($_SESSION['account']['id']);
                        Memcacher::Set($key, $listModule, 3600);
                    }


                    $tblMenu = new MenuModel();
                    $key = "cate_menu" . $_SESSION['account']['id'] . date("Ymd", time());
                    $result = Memcacher::Get($key);
                    if ($result == false) {
                        $result = $tblMenu->listMenu();
                        Memcacher::Set($key, $result, 3600);
                    }
                    if ($_GET['test'] == 1) {
                        echo "<pre>";
                        print_r($listModule);
                        echo "</pre>";
                        die();
                    }

                    $menuData = array();
                    //$_SESSION['account']['id_group'] = 2;
                    if ($_SESSION['account']['id_group'] == 1) {
                        $menuData = $result;
                    } else {
                        foreach ($result as $key => $value) {
                            if (isset($listModule[$value["id"]])) {
                                $menuData[] = $value;
                            }
                        }
                    }
                    ?>
                    <script type="text/javascript">
                var control = "<?php echo $_GET["control"] ?>";
                var func = "<?php echo $_GET["func"] ?>";
                var objMenu = <?php echo json_encode($menuData) ?>;
                function initMenu() {
                    $.each(objMenu, function (idx, element) {
                        //console.log(element.parents);
                        var li = $("<li>").addClass("datamenu")
                                .attr("id", "liMenu_" + element.id)
                                .attr("item", element.id);

                        var ahref = $("<a>").attr("href", element.url == "" ? "#" : element.url)
                                .attr("title", element.name)
                                .addClass("b_menu");
                        if (element.url == "") {
                            ahref.attr("onclick", "return false;");
                        }
                        $("<i>").addClass("fa fa-table").appendTo(ahref);
                        $("<span>").text(element.name).addClass("link-title").appendTo(ahref);
                        ahref.appendTo(li);

                        if (element.parents == 0) {
                            li.appendTo($("#ulGroup_0"));
                        } else {
                            if ($("#ulGroup_" + element.parents).length) {
                                li.appendTo($("#ulGroup_" + element.parents));
                            } else {
                                var ul = $("<ul>").attr("id", "ulGroup_" + element.parents)
                                        .attr("style", "display: none;");
                                li.appendTo(ul);
                                ul.appendTo("#liMenu_" + element.parents);
                            }
                        }
                        //?control=giftcode_lg&func=index&view=giftcode&module=all
                        //console.log(("?control=" + control + "&func=" + func).toLowerCase() == element.url.toLowerCase());
                        if ((window.location.search).toLowerCase() == element.url.toLowerCase()) {
                            ahref.addClass("active");
                            $.each(ahref.parents("ul"), function (i, els) {
                                //console.log();
                                $(els).attr("style", "display: block;");
                                $.each(ahref.parents("li"), function (si, sels) {
                                    $(sels).addClass('showmenu');
                                });
                            });
                        }
                    });
                    $('div.menu-vertical li a').click(function () {
                        //console.log($(this).children("ul"));
                        //                            $.each($(this).children("ul"), function (i, els) {
                        //                                $(els).attr("style", "display: block;");
                        //                            });
                        //function () {
                        $(this).next().slideToggle('normal');
                        //}
                    });
                }

                jQuery(document).ready(function () {
                    //console.log(objMenu);
                    initMenu();
                });

                    </script>
                    <?php
                    if ($Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()) {
                        ?>
                        <div id="smoothmenu1" class="ddsmoothmenu">
                            <ul id="ulGroup_0" class="navmenu">

                            </ul>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div id="left" class="menu-vertical" style="overflow-x: auto; height: 539px;">
                            <div class="line_menu"></div>
                            <ul id="ulGroup_0">

                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                <?php endif; ?>
                <div id="content">
                    <div class="outer">
                        <div class="inner">
                            <?php echo $content; ?>
                        </div>
                    </div>

                </div>


            </div>
            <div id="footer">
                <p>Mobile Entertainment Corporation Inside</p>
            </div>
            <?php
        } else {
            ?>
            <div style="margin-right:10px;">
                <?php echo $content; ?>
            </div>
            <?php
        }
        ?>
        <div id="mask-loading" style="width:70px; height: 70px; margin-left: -35px; margin-top: -35px;  border: #ff0000 solid 0px; position: absolute; z-index: 99999; top: 50%; left: 50%; display: none">
            <img src="<?php echo base_url('assets/img/icon/loading.gif') ?>" border="0">
        </div>
        <script type="text/javascript">
            window.onload = function () {
                document.getElementById('mask-loading').style.display = 'none';
            }
            $(function () {
                //formWizard();
            });
            $('.datamenu').click(function (event) {
                event.stopPropagation();
                var divID = '#liMenu_' + $(this).attr('item');
                $('html, body').animate({
                    scrollTop: $(divID).position().top + 70
                });
            });
            $("#menu li > span").click(function () {
                var ctr = $(this).attr('rel');
                if ($(this).hasClass('act')) {
                    $("div#" + ctr).slideUp('slow');
                    $(this).removeClass('act');
                } else {
                    $("div#" + ctr).slideDown();
                    $(this).addClass('act');
                }
            });
        </script>
    </body>
</html>