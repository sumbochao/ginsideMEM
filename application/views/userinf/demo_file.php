<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Form Wizard</title>

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/lib/Font-Awesome/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
    <link rel="stylesheet" href="assets/lib/gritter/css/jquery.gritter.css">
    <link rel="stylesheet" href="assets/lib/uniform/themes/default/css/uniform.default.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="assets/lib/jasny/css/jasny-bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
      <script src="assets/lib/html5shiv/html5shiv.js"></script>
	      <script src="assets/lib/respond/respond.min.js"></script>
	    <![endif]-->

    <!--Modernizr 3.0-->
    <script src="assets/lib/modernizr-build.min.js"></script>
  </head>
  <body>
    <div id="wrap">
      <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="index.html" class="navbar-brand">
              <img src="assets/img/logo.png" alt="">
            </a>
          </header>
          <div class="topnav">
            <div class="btn-toolbar">
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Show / Hide Sidebar" data-toggle="tooltip" class="btn btn-success btn-sm" id="changeSidebarPos">
                  <i class="fa fa-expand"></i>
                </a>
              </div>
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" class="btn btn-default btn-sm">
                  <i class="fa fa-envelope"></i>
                  <span class="label label-warning">5</span>
                </a>
                <a data-placement="bottom" data-original-title="Messages" href="#" data-toggle="tooltip" class="btn btn-default btn-sm">
                  <i class="fa fa-comments"></i>
                  <span class="label label-danger">4</span>
                </a>
              </div>
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Document" href="#" data-toggle="tooltip" class="btn btn-default btn-sm">
                  <i class="fa fa-file"></i>
                </a>
                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                  <i class="fa fa-question"></i>
                </a>
              </div>
              <div class="btn-group">
                <a href="login.html" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a>
              </div>
            </div>
          </div><!-- /.topnav -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">

            <!-- .nav -->
            <ul class="nav navbar-nav">
              <li> <a href="dashboard.html">Dashboard</a> </li>
              <li> <a href="table.html">Tables</a> </li>
              <li> <a href="file.html">File Manager</a> </li>
              <li class='dropdown active'>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Form Elements
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li> <a href="form-general.html">General</a> </li>
                  <li> <a href="form-validation.html">Validation</a> </li>
                  <li> <a href="form-wysiwyg.html">WYSIWYG</a> </li>
                  <li> <a href="form-wizard.html">Wizard &amp; File Upload</a> </li>
                </ul>
              </li>
            </ul><!-- /.nav -->
          </div>
        </nav><!-- /.navbar -->

        <!-- header.head -->
        <header class="head">
          <div class="search-bar">
            <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
              <i class="fa fa-expand"></i>
            </a>
            <form class="main-search">
              <div class="input-group">
                <input type="text" class="input-small form-control" placeholder="Live Search ...">
                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm text-muted" type="button"><i class="fa fa-search"></i></button>
                                </span>
              </div>
            </form>
          </div>

          <!-- ."main-bar -->
          <div class="main-bar">
            <h3>
              <i class="fa fa-magic"></i>Form Wizard</h3>
          </div><!-- /.main-bar -->
        </header>

        <!-- end header.head -->
      </div><!-- /#top -->
      <div id="left">
        <div class="media user-media">
          <a class="user-link" href="">
            <img class="media-object img-thumbnail user-img" alt="User Picture" src="assets/img/user.gif">
            <span class="label label-danger user-label">16</span>
          </a>
          <div class="media-body">
            <h5 class="media-heading">Archie</h5>
            <ul class="list-unstyled user-info">
              <li> <a href="">Administrator</a> </li>
              <li>Last Access :
                <br>
                <small>
                  <i class="fa fa-calendar"></i>&nbsp;16 Mar 16:32</small>
              </li>
            </ul>
          </div>
        </div>

        <!-- #menu -->
        <ul id="menu" class="collapse">
          <li class="nav-header">Menu</li>
          <li class="nav-divider"></li>
          <li class="">
            <a href="javascript:;">
              <i class="fa fa-dashboard"></i>
              <span class="link-title">Dashboard</span>
              <span class="fa arrow"></span>
            </a>
            <ul>
              <li class="">
                <a href="dashboard.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Default Style
                </a>
              </li>
              <li class="">
                <a href="alterne.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Alternative Style
                </a>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <i class="fa fa-tasks"></i>&nbsp;Components
              <span class="fa arrow"></span>
            </a>
            <ul>
              <li class="">
                <a href="icon.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Icon</a>
              </li>
              <li class="">
                <a href="button.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Button</a>
              </li>
              <li class="">
                <a href="progress.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Progress</a>
              </li>
              <li class="">
                <a href="pricing.html">
                  <i class="fa fa-credit-card"></i>&nbsp;Pricing Table</a>
              </li>
              <li class="">
                <a href="bgimage.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Bg Image</a>
              </li>
              <li class="">
                <a href="bgcolor.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Bg Color</a>
              </li>
            </ul>
          </li>
          <li class="active">
            <a href="javascript:;">
              <i class="fa fa-pencil"></i>&nbsp;Forms
              <span class="fa arrow"></span>
            </a>
            <ul>
              <li class="">
                <a href="form-general.html">
                  <i class="fa fa-angle-right"></i>&nbsp;General</a>
              </li>
              <li class="">
                <a href="form-validation.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Validation</a>
              </li>
              <li class="">
                <a href="form-wysiwyg.html">
                  <i class="fa fa-angle-right"></i>&nbsp;WYSIWYG</a>
              </li>
              <li class="active">
                <a href="form-wizard.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Wizard &amp; File Upload</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="table.html">
              <i class="fa fa-table"></i>&nbsp; Tables</a>
          </li>
          <li>
            <a href="file.html">
              <i class="fa fa-file"></i>&nbsp;File Manager</a>
          </li>
          <li>
            <a href="typography.html">
              <i class="fa fa-font"></i>&nbsp; Typography</a>
          </li>
          <li>
            <a href="maps.html">
              <i class="fa fa-map-marker"></i>&nbsp;Maps</a>
          </li>
          <li>
            <a href="chart.html">
              <i class="fa fa fa-bar-chart-o"></i>&nbsp;Charts</a>
          </li>
          <li>
            <a href="calendar.html">
              <i class="fa fa-calendar"></i>&nbsp;Calendar</a>
          </li>
          <li>
            <a href="javascript:;">
              <i class="fa fa-exclamation-triangle"></i>&nbsp;Error Pages
              <span class="fa arrow"></span>
            </a>
            <ul>
              <li>
                <a href="403.html">
                  <i class="fa fa-angle-right"></i>&nbsp;403</a>
              </li>
              <li>
                <a href="404.html">
                  <i class="fa fa-angle-right"></i>&nbsp;404</a>
              </li>
              <li>
                <a href="405.html">
                  <i class="fa fa-angle-right"></i>&nbsp;405</a>
              </li>
              <li>
                <a href="500.html">
                  <i class="fa fa-angle-right"></i>&nbsp;500</a>
              </li>
              <li>
                <a href="503.html">
                  <i class="fa fa-angle-right"></i>&nbsp;503</a>
              </li>
              <li>
                <a href="offline.html">
                  <i class="fa fa-angle-right"></i>&nbsp;offline</a>
              </li>
              <li>
                <a href="countdown.html">
                  <i class="fa fa-angle-right"></i>&nbsp;Under Construction</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="grid.html">
              <i class="fa fa-columns"></i>&nbsp;Grid</a>
          </li>
          <li>
            <a href="blank.html">
              <i class="fa fa-square-o"></i>&nbsp;Blank Page</a>
          </li>
          <li class="nav-divider"></li>
          <li>
            <a href="login.html">
              <i class="fa fa-sign-in"></i>&nbsp;Login Page</a>
          </li>
          <li>
            <a href="javascript:;">Unlimited Level Menu  <span class="fa arrow"></span> </a>
            <ul>
              <li>
                <a href="javascript:;">Level 1  <span class="fa arrow"></span> </a>
                <ul>
                  <li> <a href="javascript:;">Level 2</a> </li>
                  <li> <a href="javascript:;">Level 2</a> </li>
                  <li>
                    <a href="javascript:;">Level 2  <span class="fa arrow"></span> </a>
                    <ul>
                      <li> <a href="javascript:;">Level 3</a> </li>
                      <li> <a href="javascript:;">Level 3</a> </li>
                      <li>
                        <a href="javascript:;">Level 3  <span class="fa arrow"></span> </a>
                        <ul>
                          <li> <a href="javascript:;">Level 4</a> </li>
                          <li> <a href="javascript:;">Level 4</a> </li>
                          <li>
                            <a href="javascript:;">Level 4  <span class="fa arrow"></span> </a>
                            <ul>
                              <li> <a href="javascript:;">Level 5</a> </li>
                              <li> <a href="javascript:;">Level 5</a> </li>
                              <li> <a href="javascript:;">Level 5</a> </li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li> <a href="javascript:;">Level 4</a> </li>
                    </ul>
                  </li>
                  <li> <a href="javascript:;">Level 2</a> </li>
                </ul>
              </li>
              <li> <a href="javascript:;">Level 1</a> </li>
              <li>
                <a href="javascript:;">Level 1  <span class="fa arrow"></span> </a>
                <ul>
                  <li> <a href="javascript:;">Level 2</a> </li>
                  <li> <a href="javascript:;">Level 2</a> </li>
                  <li> <a href="javascript:;">Level 2</a> </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul><!-- /#menu -->
      </div><!-- /#left -->
      <div id="content">
        <div class="outer">
          <div class="inner">
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header class="dark">
                    <div class="icons">
                      <i class="fa fa-cloud-upload"></i>
                    </div>
                    <h5>File Upload</h5>
                  </header>
                  <div class="body">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label class="control-label col-lg-4">Browser Default</label>
                        <div class="col-lg-8">
                          <input type="file">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">Uniform Style</label>
                        <div class="col-lg-8">
                          <input type="file" id="fileUpload" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">Bootstrap Style</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                <input type="file" name="...">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">No Input</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file">
				<span class="fileinput-new">Select file</span>
                            <span class="fileinput-exists">Change</span>
                              <input type="file" name="...">
                            </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">Image Upload</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                <input type="file" name="...">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">Pre Defined Image</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                              <img data-src="holder.js/100%x100%" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                <input type="file" name="...">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="alert alert-warning"><strong>Notice!</strong> Image preview only works in IE10+, FF3.6+, Chrome6.0+ and Opera11.1+. In older browsers and Safari, the filename is shown instead.</div>
                    </form>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <h5>Multiple Uploader</h5>
                  </header>
                  <div id="collapse2" class="block">
                    <form>
                      <div id="uploader"></div>
                    </form>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <h5>Wizard with Validation</h5>
                  </header>
                  <div id="div-2" class="body">
                    <form id="wizardForm" method="post" action="" class="form-horizontal wizardForm">
                      <fieldset class="step" id="first">
                        <h4 class="text-danger pull-right">Database Settings</h4>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label for="server_host" class="control-label col-lg-4">Database Server</label>
                          <div class="col-lg-8">
                            <input type="text" name="server_host" id="server_host" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="server_name" class="control-label col-lg-4">Database Name</label>
                          <div class="col-lg-8">
                            <input type="text" name="server_name" id="server_name" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="server_user" class="control-label col-lg-4">Database User</label>
                          <div class="col-lg-8">
                            <input type="text" name="server_user" id="server_user" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="server_password" class="control-label col-lg-4">User Password</label>
                          <div class="col-lg-8">
                            <input type="password" name="server_password" id="server_password" class="form-control">
                          </div>
                        </div>
                      </fieldset>
                      <fieldset class="step" id="second">
                        <h4 class="text-warning pull-right">Table Settings</h4>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label for="table_prefix" class="control-label col-lg-4">Table Prefix</label>
                          <div class="col-lg-8">
                            <input type="text" name="table_prefix" id="table_prefix" value="nuro_" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="table_collation" class="control-label col-lg-4">Table Collation</label>
                          <div class="col-lg-8">
                            <select name="table_collation" id="table_collation" class="form-control">
                              <option value="">Collation</option>
                              <option value=""></option>
                              <optgroup label="utf8" title="UTF-8 Unicode">
                                <option value="utf8_bin" title="Unicode (multilingual), Binary">
                                  utf8_bin
                                </option>
                                <option value="utf8_czech_ci" title="Czech, case-insensitive">
                                  utf8_czech_ci
                                </option>
                                <option value="utf8_danish_ci" title="Danish, case-insensitive">
                                  utf8_danish_ci
                                </option>
                                <option value="utf8_esperanto_ci" title="Esperanto, case-insensitive">utf8_esperanto_ci
                                </option>
                                <option value="utf8_estonian_ci" title="Estonian, case-insensitive">utf8_estonian_ci
                                </option>
                                <option value="utf8_general_ci" title="Unicode (multilingual), case-insensitive">
                                  utf8_general_ci
                                </option>
                                <option value="utf8_general_mysql500_ci" title="Unicode (multilingual)">utf8_general_mysql500_ci
                                </option>
                                <option value="utf8_hungarian_ci" title="Hungarian, case-insensitive">utf8_hungarian_ci
                                </option>
                                <option value="utf8_icelandic_ci" title="Icelandic, case-insensitive">utf8_icelandic_ci
                                </option>
                                <option value="utf8_latvian_ci" title="Latvian, case-insensitive">utf8_latvian_ci
                                </option>
                                <option value="utf8_lithuanian_ci" title="Lithuanian, case-insensitive">utf8_lithuanian_ci
                                </option>
                                <option value="utf8_persian_ci" title="Persian, case-insensitive">utf8_persian_ci
                                </option>
                                <option value="utf8_polish_ci" title="Polish, case-insensitive">
                                  utf8_polish_ci
                                </option>
                                <option value="utf8_roman_ci" title="West European, case-insensitive">utf8_roman_ci
                                </option>
                                <option value="utf8_romanian_ci" title="Romanian, case-insensitive">utf8_romanian_ci
                                </option>
                                <option value="utf8_sinhala_ci" title="unknown, case-insensitive">utf8_sinhala_ci
                                </option>
                                <option value="utf8_slovak_ci" title="Slovak, case-insensitive">
                                  utf8_slovak_ci
                                </option>
                                <option value="utf8_slovenian_ci" title="Slovenian, case-insensitive">utf8_slovenian_ci
                                </option>
                                <option value="utf8_spanish2_ci" title="Traditional Spanish, case-insensitive">
                                  utf8_spanish2_ci
                                </option>
                                <option value="utf8_spanish_ci" title="Spanish, case-insensitive">utf8_spanish_ci
                                </option>
                                <option value="utf8_swedish_ci" title="Swedish, case-insensitive">utf8_swedish_ci
                                </option>
                                <option value="utf8_turkish_ci" title="Turkish, case-insensitive">utf8_turkish_ci
                                </option>
                                <option value="utf8_unicode_ci" title="Unicode (multilingual), case-insensitive">
                                  utf8_unicode_ci
                                </option>
                              </optgroup>
                              <optgroup label="utf8mb4" title="UTF-8 Unicode">
                                <option value="utf8mb4_bin" title="unknown, Binary">
                                  utf8mb4_bin
                                </option>
                                <option value="utf8mb4_czech_ci" title="Czech, case-insensitive">utf8mb4_czech_ci
                                </option>
                                <option value="utf8mb4_danish_ci" title="Danish, case-insensitive">utf8mb4_danish_ci
                                </option>
                                <option value="utf8mb4_esperanto_ci" title="Esperanto, case-insensitive">utf8mb4_esperanto_ci
                                </option>
                                <option value="utf8mb4_estonian_ci" title="Estonian, case-insensitive">utf8mb4_estonian_ci
                                </option>
                                <option value="utf8mb4_general_ci" title="unknown, case-insensitive">utf8mb4_general_ci
                                </option>
                                <option value="utf8mb4_hungarian_ci" title="Hungarian, case-insensitive">utf8mb4_hungarian_ci
                                </option>
                                <option value="utf8mb4_icelandic_ci" title="Icelandic, case-insensitive">utf8mb4_icelandic_ci
                                </option>
                                <option value="utf8mb4_latvian_ci" title="Latvian, case-insensitive">utf8mb4_latvian_ci
                                </option>
                                <option value="utf8mb4_lithuanian_ci" title="Lithuanian, case-insensitive">
                                  utf8mb4_lithuanian_ci
                                </option>
                                <option value="utf8mb4_persian_ci" title="Persian, case-insensitive">utf8mb4_persian_ci
                                </option>
                                <option value="utf8mb4_polish_ci" title="Polish, case-insensitive">utf8mb4_polish_ci
                                </option>
                                <option value="utf8mb4_roman_ci" title="West European, case-insensitive">utf8mb4_roman_ci
                                </option>
                                <option value="utf8mb4_romanian_ci" title="Romanian, case-insensitive">utf8mb4_romanian_ci
                                </option>
                                <option value="utf8mb4_sinhala_ci" title="unknown, case-insensitive">utf8mb4_sinhala_ci
                                </option>
                                <option value="utf8mb4_slovak_ci" title="Slovak, case-insensitive">utf8mb4_slovak_ci
                                </option>
                                <option value="utf8mb4_slovenian_ci" title="Slovenian, case-insensitive">utf8mb4_slovenian_ci
                                </option>
                                <option value="utf8mb4_spanish2_ci" title="Traditional Spanish, case-insensitive">
                                  utf8mb4_spanish2_ci
                                </option>
                                <option value="utf8mb4_spanish_ci" title="Spanish, case-insensitive">utf8mb4_spanish_ci
                                </option>
                                <option value="utf8mb4_swedish_ci" title="Swedish, case-insensitive">utf8mb4_swedish_ci
                                </option>
                                <option value="utf8mb4_turkish_ci" title="Turkish, case-insensitive">utf8mb4_turkish_ci
                                </option>
                                <option value="utf8mb4_unicode_ci" title="Unicode (multilingual), case-insensitive">
                                  utf8mb4_unicode_ci
                                </option>
                              </optgroup>
                            </select>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset class="step" id="last">
                        <h4 class="text-primary pull-right">User Settings</h4>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label for="username" class="control-label col-lg-4">Username</label>
                          <div class="col-lg-8">
                            <input type="text" name="username" id="username" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="usermail" class="control-label col-lg-4">E-mail</label>
                          <div class="col-lg-8">
                            <input type="text" name="usermail" id="usermail" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="pass" class="control-label col-lg-4">User Password</label>
                          <div class="col-lg-8">
                            <input type="password" name="pass" id="pass" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="pass2" class="control-label col-lg-4">Confirm Password</label>
                          <div class="col-lg-8">
                            <input type="password" name="pass2" id="pass2" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-8">
                            <label class="checkbox">
                              <input type="checkbox" class="form-control">Remember me
                            </label>
                          </div>
                        </div>
                      </fieldset>
                      <div class="form-actions">
                        <input class="navigation_button btn" id="back" value="Back" type="reset" />
                        <input class="navigation_button btn btn-primary" id="next" value="Next" type="submit" />
                      </div>
                    </form>
                    <div id="data"></div>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
          </div>

          <!-- end .inner -->
        </div>

        <!-- end .outer -->
      </div>

      <!-- end #content -->
    </div><!-- /#wrap -->
    <div id="footer">
      <p>2013 &copy; Metis Admin</p>
    </div>

    <!-- #helpModal -->
    <div id="helpModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
              in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->
    <script src="assets/lib/jquery.min.js"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/style-switcher.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
    <script src="assets/lib/plupload/js/plupload.full.min.js"></script>
    <script src="assets/lib/gritter/js/jquery.gritter.min.js"></script>
    <script src="assets/lib/uniform/jquery.uniform.min.js"></script>
    <script src="assets/lib/jasny/js/jasny-bootstrap.min.js"></script>
    <script src="assets/lib/form/jquery.form.js"></script>
    <script src="assets/lib/formwizard/js/jquery.form.wizard.js"></script>
    <script src="assets/lib/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
    <script src="assets/lib/jquery-validation-1.11.1/localization/messages_ja.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script>
      $(function() {
        formWizard();
      });
    </script>
  </body>
</html>