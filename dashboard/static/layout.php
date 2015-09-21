<?php

include_once 'includes/services.php';
include_once 'includes/menu.php';

function headLayout() {
    $header = '<head>
        <meta charset="UTF-8">
        <title>Dashboard |Moche </title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="../../static/css/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../static/css/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../../static/css/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../static/css/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>';

    return $header;
}

function mensajeGeneral($mensaje, $modulo) {

    if ($mensaje == 1) {
        $mensajeRetorno = '
                               <div class="alert alert-success alert-dismissable">
                                   <i class="fa fa-check"></i>
                                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <b>' . $modulo . ' creado correctamente.</b>
                               </div>
                           ';
    } elseif ($mensaje == 2) {
        $mensajeRetorno = '
                               <div class="alert alert-success alert-dismissable">
                                   <i class="fa fa-check"></i>
                                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <b>Error al insertar ' . $modulo . '.</b>
                               </div>
                           ';
    }
    return $mensajeRetorno;
}

function headerLayout($name) {
    $header .= '<header class="header" >
            <a href="/' . AMBIENTE . '/modulos/Admin/home.phtml" class="logo">
                <!-- Add the class .icon to your logo image or logo icon to add some margining -->
                Sipan
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>' . htmlentities($name) . ' <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="../../static/css/img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        ' . htmlentities($name) . '
                                        <small>Miembro. 2015</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
<!--                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">';
    $header .=agregarUsuario();
    $header .=' <div class="pull-right">
                                        <a href="../../modulos/Admin/controllers/logout.php" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>';

    return $header;
}

function agregarUsuario() {
    if ($_SESSION['user_id'] !== 0 ) {
        $campo = '   <div class="pull-left">
                                        <a href="../../modulos/Admin/register.phtml" class="btn btn-default btn-flat">Agregar Usuario</a>
                                    </div>';
    } else {
        $campo = '';
    }
    return $campo;
}

function menu() {
    $menu = array(
        0 => array('url' => '#',
            'descripcion' => 'Clientes Potenciales',
            'hijos' => array(
                array(
                    'url' => '../../modulos/ClientesPotenciales/cliente-natural.phtml',
                    'descripcion' => 'Clientes Natural',
                    'nietos' => array(
                        array('url' => '../../modulos/ClientesPotenciales/cliente-natural-editar.phtml'),
                        array('url' => '../../modulos/ClientesPotenciales/cliente-natural-insertar.phtml')
                    )
                ),
                array(
                    'url' => '../../modulos/ClientesPotenciales/cliente-juridico.phtml',
                    'descripcion' => 'Cliente Juridicos',
                    'nietos' => array(
                        array('url' => '../../modulos/ClientesPotenciales/cliente-juridico-editar.phtml'),
                        array('url' => '../../modulos/ClientesPotenciales/cliente-juridico-insertar.phtml')
                    ))
            )
        ),
        1 => array('url' => '#', 'descripcion' => 'Contratos Naturales',
            'hijos' => array(
                array('url' => '../../modulos/Contratos/contratos-pendientes.phtml',
                    'descripcion' => 'Contratos Pendientes',
                    'nietos' => array(
                        array('url' => '../../modulos/Contratos/contrato-editar.phtml')
                    )),
                array('url' => '../../modulos/Contratos/contratos.phtml',
                    'descripcion' => 'Contratos En Curso',
                    'nietos' => array(
                        array('url' => '../../modulos/Contratos/contrato-editar.phtml')
                    )))),
        2 => array('url' => '#', 'descripcion' => 'Contratos Juridicos',
            'hijos' => array(
                array('url' => '../../modulos/Contratos/contratos-juridico-pendientes.phtml',
                    'descripcion' => 'Contratos Pendientes',
                    'nietos' => array(
                        array('url' => '../../modulos/Contratos/contrato-editar.phtml')
                    )),
                array('url' => '../../modulos/Contratos/contratos-juridico.phtml',
                    'descripcion' => 'Contratos En Curso',
                    'nietos' => array(
                        array('url' => '../../modulos/Contratos/contrato-juridico-editar.phtml')
                    )))),
        3 => array('url' => '#', 'descripcion' => 'Ordenes',
            'hijos' => array(array('url' => '../../modulos/Ordenes/ordenes-cliente.phtml',
                    'descripcion' => 'Nuevas Ordenes'),
                array('url' => '../../modulos/Ordenes/ordenes-cliente-revisado.phtml',
                    'descripcion' => 'Ordenes  Revisadas'))
        ),
        4 => array('url' => '../../modulos/Planes/cliente-tipo-plan.phtml', 'descripcion' => 'Planes (Telefonía)',
            'hijos' => null),
        5 => array('url' => '../../modulos/Predios/listar-predios.phtml', 'descripcion' => 'Predios',
            'hijos' => null, 'nietos' => array(
                array('url' => '../../modulos/Predios/predios-editar.phtml'),
                array('url' => '../../modulos/Predios/predios-insertar.phtml')
            )),
        6 => array('url' => '../../modulos/Facturacion/boletas.phtml', 'descripcion' => 'Facturación',
            'hijos' => null)
    );
    return $menu;
}

function menuLayout($name) {
    $nombre_archivo = $_SERVER['REQUEST_URI'];
    $url = explode("/", $nombre_archivo);
    $posicion_coincidencia = strpos($url[4], "?");
    if ($posicion_coincidencia) {
        $dominio = substr($url[4], 0, $posicion_coincidencia);
        $url[4] = $dominio;
    }
    $url[4] = '../../' . $url[2] . '/' . $url[3] . '/' . $url[4];
    echo ' <section class="sidebar" >
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="../../static/css/img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hola,  ' . htmlentities($name) . '</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">';
    $servicios = new servicios();
    $valores = create_list();
    foreach ($valores as $value) {
        if ($value['hijos']) {
            $re = $servicios->filter_by_value($value['hijos'], 'url', $url[4]);
//            foreach ($value['hijos'] as $va) { 
//              $niet[] = $servicios->filter_by_value($va['nietos'], 'url', $url[2]);  
//            }
//         var_dump($niet[0][0]["url"]);exit;
//            $nieto = $servicios->filter_by_value($value['nietos'], 'url', $url[2]);
            if (isset($re)) {
                $info = 'treeview active';
                echo '<li class="' . $info . '">';
            } else {
                $info = 'treeview';
                echo '<li class="' . $info . '">';
            }
        } else {
            $nieto = $servicios->filter_by_value($value['nietos'], 'url', $url[4]);
            if ($nieto || $value['url'] == $url[4]) {
                echo '<li class="active">';
            } else {
                echo '<li class="">';
            }
        }
        echo '<a href="' . $value['url'] . '">
                                                    <i class="fa fa-table"></i> <span>' . $value['descripcion'] . '</span>';
        if ($value['hijos']) :
            echo '<i class="fa fa-angle-left pull-right"></i>';
        endif;
        echo '  </a>';
        if ($value['hijos']) {
            echo '<ul class="treeview-menu">';
            foreach ($value['hijos'] as $valor) {
                echo $valor['url'] == $url[4] ? '<li class="active">' : '<li class="">';
                echo'   <a href="' . $valor['url'] . '"><i class="fa fa-angle-double-right"></i>' . $valor['descripcion'] . '</a>
                                         </li>';
            }
            echo '</ul>';
        }
        echo'        </li>';
    }
    echo ' </ul>
                </section>
                <!-- /.sidebar -->
            </aside>';
}

function scripts() {
    $scrypt = '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>';

    return $scrypt;
}
