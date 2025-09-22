<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $submenu = 3401;
   $menu = 34;
   require 'header.php';
   if ($_SESSION['widgets'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
        <section class="content p-0">
            <div class="row p-0 m-0">
                <div class="col-12 pt-4 migas">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="titulo-4"> Dashboard </h2>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Biblioteca CIAF</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content pt-4 pl-4">
           
                <div class="row">

                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                        <div class="card hidden px-4">
                            <div class="row">
                                <div class="col-12 py-3">
                                    <h2 class="text-semibold fs-18">Sitio A Trafico</h2>
                                </div>
                                <div class="col-3 border-right">
                                    <h3 class="text-regular fs-14">Años</h3>
                                    <span class="fs-16 pointer">40.20%</span> 
                                </div>
                                <div class="col-3 text-muted border-right">
                                    <h3 class="text-regular fs-14">Meses</h3>
                                    <span class="fs-16 pointer">60.10%</span>
                                    
                                </div>
                                <div class="col-3 text-muted">
                                    <h3 class="text-regular fs-14">Diario</h3>
                                    <span class="fs-16 pointer">80.40%</span>
                                </div>
                                <div id="spark2" class="col-12">
                                    <div id="chartContainer" style="height: 120px; width: 128%; margin-left:-14.5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                        <div class="card  px-4">
                            <div class="row hidden">
                                <div class="col-12 py-3 ">
                                    <h2 class="text-semibold fs-18">Sitio B Trafico</h2>
                                </div>
                                <div class="col-3 border-right">
                                    <h3 class="text-regular fs-14">Años</h3>
                                    <span class="fs-16 pointer">40.20%</span> 
                                </div>
                                <div class="col-3 text-muted border-right">
                                    <h3 class="text-regular fs-14">Meses</h3>
                                    <span class="fs-16 pointer">60.10%</span>
                                    
                                </div>
                                <div class="col-3 text-muted">
                                    <h3 class="text-regular fs-14">Diario</h3>
                                    <span class="fs-16 pointer">80.40%</span>
                                </div>
                                <div id="spark2" class="col-12">
                                    <div id="chartContainer2" style="height: 120px; width: 128%; margin-left:-14.5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                        <div class="card hidden px-4">
                            <div class="row">
                                <div class="col-12 py-3 ">
                                    <h2 class="text-semibold fs-18">Sitio C Trafico</h2>
                                </div>
                                <div class="col-3 border-right">
                                    <h3 class="text-regular fs-14">Años</h3>
                                    <span class="fs-16 pointer">40.20%</span> 
                                </div>
                                <div class="col-3 text-muted border-right">
                                    <h3 class="text-regular fs-14">Meses</h3>
                                    <span class="fs-16 pointer">60.10%</span>
                                    
                                </div>
                                <div class="col-3 text-muted">
                                    <h3 class="text-regular fs-14">Diario</h3>
                                    <span class="fs-16 pointer">80.40%</span>
                                </div>
                                <div id="spark2" class="col-12">
                                    <div id="chartContainer3" style="height: 120px; width: 128%; margin-left:-14.5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="row justify-content-center">
                            <div class="col-11 hidden">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar rounded bg-light-green">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="small mb-0">Income</p>
                                        <h4 class="text-dark mb-0"><span class="text-semibold">52000</span> <small class="text-regular">USD</small></h4>
                                        <p class="small">36.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="row justify-content-center">
                            <div class="col-11 hidden">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar rounded bg-light-blue">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="small mb-0">Income</p>
                                        <h4 class="text-dark mb-0"><span class="text-semibold">52000</span> <small class="text-regular">USD</small></h4>
                                        <p class="small">36.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="row justify-content-center">
                            <div class="col-11 hidden">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar rounded bg-light-red">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="small mb-0">Income</p>
                                        <h4 class="text-dark mb-0"><span class="text-semibold">52000</span> <small class="text-regular">USD</small></h4>
                                        <p class="small">36.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="row justify-content-center">
                            <div class="col-11 hidden">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar rounded bg-light-yellow">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="small mb-0">Income</p>
                                        <h4 class="text-dark mb-0"><span class="text-semibold">52000</span> <small class="text-regular">USD</small></h4>
                                        <p class="small">36.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card col-12">
                            <div class="row">
                                <div class="col-12 py-4 text-center bg-primary">
                                    <i class="fa fa-facebook fa-2x"></i>
                                </div>
                                <div class="col-6 b-r text-center py-2 border-right">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Followers</h5>
                                </div>
                                <div class="col-6 text-center py-2">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Posts</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card col-12">
                            <div class="row ">
                                <div class="col-12 py-4 text-center bg-primary">
                                    <i class="fa fa fa-twitter fa-2x"></i>
                                </div>
                                <div class="col-6 b-r text-center py-2 border-right">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Followers</h5>
                                </div>
                                <div class="col-6 text-center py-2">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Posts</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card col-12">
                            <div class="row ">
                                <div class="col-12 py-4 text-center bg-danger">
                                    <i class="fa fa-google-plus fa-2x"></i>
                                </div>
                                <div class="col-6 b-r text-center py-2 border-right">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Followers</h5>
                                </div>
                                <div class="col-6 text-center py-2">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Posts</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card col-12">
                            <div class="row ">
                                <div class="col-12 py-4 text-center bg-primary">
                                    <i class="fa fa-linkedin fa-2x"></i>
                                </div>
                                <div class="col-6 b-r text-center py-2 border-right">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Followers</h5>
                                </div>
                                <div class="col-6 text-center py-2">
                                    <h3 class="text-semibold fs-20">456</h3>
                                    <h5 class="fs-16">Posts</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-3">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-12">
                                    <h3>86%</h3>
                                    <h6 class="card-subtitle">Total Product</h6></div>
                                <div class="col-12">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-12">
                                    <h3>86%</h3>
                                    <h6 class="card-subtitle">Total Product</h6></div>
                                <div class="col-12">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-12">
                                    <h3>86%</h3>
                                    <h6 class="card-subtitle">Total Product</h6></div>
                                <div class="col-12">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-12">
                                    <h3>86%</h3>
                                    <h6 class="card-subtitle">Total Product</h6></div>
                                <div class="col-12">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-3">
                        <div class="card col-12 py-2">
                        
                            <div class="row">
                                <div class="col-4">
                                    <i class="fa-solid fa-right-to-bracket bg-light-red avatar rounded fa-2x"></i>
                                </div>
                                <div class="col-8 pt-2">
                                    <div class="small text-regular">Ingresos</div>
                                    <div class="fs-20">CAMPUS</div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            
                                <!-- <div class="smallchart80 mb-2">
                                    <canvas id="barchartpink" style="display: block; box-sizing: border-box; height: 80px; width: 172px;" width="172" height="80"></canvas>
                                </div> -->
                                
                                <div class="col-6">
                                    <p class="text-secondary small mb-0">Colaboradores</p>
                                    <p class="pointer">55.15 k</p>
                                </div>

                                <div class="col-6 text-right">
                                    <p class="text-secondary small mb-0">Docentes</p>
                                    <p class="pointer">11.2 k</p>
                                </div>
                                
                                <div class="col-6">
                                    <p class="text-secondary small mb-0">Estudiantes</p>
                                    <p class="pointer">1.5 m</p>
                                </div>

                                <div class="col-6 text-right">
                                    <p class="text-secondary small mb-0">Total</p>
                                    <p>60.01 k</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 p-4">
                        <div class="card card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Messages</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-header">
                            <h3 class="card-title">Collapsible Accordion</h3>
                        </div>
                        <div class="">
                            <div id="accordion">
                                <div class="card-header tono-4">
                                    <h4 class="card-title w-100">
                                    <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                        <div class="spinner-grow text-muted spinner-grow-sm"></div>
                                        Collapsible Group Item #1
                                    </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                    <div class="card-body tono-3">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                    3
                                    wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                    laborum
                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                    nulla
                                    assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                    nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                    beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                    labore sustainable VHS.
                                    </div>
                                </div>
                                <div class="card-header tono-4">
                                    <h4 class="card-title w-100">
                                    <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
                                        <div class="spinner-grow text-muted spinner-grow-sm"></div>
                                        Collapsible Group Danger
                                    </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body tono-3">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                    3
                                    wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                    laborum
                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                    nulla
                                    assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                    nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                    beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                    labore sustainable VHS.
                                    </div>
                                </div>
                                <div class="card-header tono-4">
                                    <h4 class="card-title w-100">
                                    <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseThree">
                                        <div class="spinner-grow text-muted spinner-grow-sm"></div>
                                        Collapsible Group Success
                                    </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="card-body tono-3">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                                    3
                                    wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                    laborum
                                    eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                    nulla
                                    assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                    nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                    beer
                                    farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                    labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-4 mt-4 ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-50 rounded bg-light-blue">
                                            <i class="bi bi-bag-check h5"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="small text-secondary mb-1">On hand</p>
                                        <h4 class="fw-medium">523 <small>Units</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-50 rounded bg-light-cyan">
                                            <i class="bi bi-bag-check h5"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="small text-secondary mb-1">Manufacturing</p>
                                        <h4 class="fw-medium">245 <small>Units</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-50 rounded bg-light-yellow">
                                            <i class="bi bi-clipboard-check h5"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="small text-secondary mb-1">Processed</p>
                                        <h4 class="fw-medium">135 <small>Units</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-50 rounded bg-light-red">
                                            <i class="bi bi-geo-alt h5"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="small text-secondary mb-1">Delivered</p>
                                        <h4 class="fw-medium">6521 <small>Units</small></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-50 rounded bg-light-green">
                                            <i class="bi bi-cart-x h5"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="small text-secondary mb-1">Rejected/Cancelled</p>
                                        <h4 class="fw-medium">13 <small>Units</small></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressblue">
                                                <svg viewBox="0 0 100 100" style="display: block;">
                                                    <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(66, 157, 255, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                                    <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(1,94,194)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 98.9741;"></path></svg>
                                                </div>
                                            <div class="avatar icono-circle h6 bg-light-blue rounded-circle">
                                                <i class="fa-solid fa-chart-simple fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <p class="text-secondary small mb-1">Connected Devices</p>
                                        <h5 class="titulo-2 fs-28 text-semibold">70250</h5>
                                    </div>
  
                                </div>
                            </div>
                            <div class="card-footer borde-top">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-secondary small fs-14 m-0">New Users</p>
                                        <p class="titulo-2 line-height-18 fs-14 m-0 p-0">5 <small class="fs-12 fw-light text-secondary">This week</small></p>
                                    </div>
                                    <div class="col-6 border-left-dashed">
                                        <p class="text-secondary small m-0 fs-14">Total Users</p>
                                        <p class="mb-0">65826</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card ">
                            <div class="tono-3 p-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="fa-solid fa-chart-simple p-3 bg-light-purple text-purple rounded fa-2x"></i>
                                    </div>
                                    <div class="col ">
                                        <span class="titulo-2 fs-20 text-semibold ">Expense</span><br>
                                        <span class="small text-secondary ">Categories</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="col-12 text-center p-4">
                                    aquí el grafico
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <h6 class="titulo-2 fs-18 text-semibold">Top Categories</h6>
                                    </div>
                                    <div class="col-auto pt-2">
                                        <span class="text-secondary fs-14">Values in thousand</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="rounded bg-light-yellow">
                                                    <i class="fa-solid fa-droplet text-warning p-3"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0 pt-2">
                                                <span class="titulo-2 fs-16 line-height-16 text-semibold">400 <small class="fs-10">USD</small></span>
                                                <span class="fs-14">Food</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="rounded bg-light-green">
                                                    <i class="fa-solid fa-truck text-success p-3"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0 pt-2">
                                                <span class="titulo-2 fs-16 line-height-16 text-semibold">400 <small class="fs-10">USD</small></span>
                                                <span class="fs-14">Food</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="rounded bg-light-red">
                                                    <i class="fa-regular fa-user text-danger p-3"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0 pt-2">
                                                <span class="titulo-2 fs-16 line-height-16 text-semibold">400 <small class="fs-10">USD</small></span>
                                                <span class="fs-14">Food</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="rounded bg-light-blue">
                                                    <i class="fa-solid fa-house text-primary p-3"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0 pt-2">
                                                <span class="titulo-2 fs-16 line-height-16 text-semibold">400 <small class="fs-10">USD</small></span>
                                                <span class="fs-14">Food</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                


                
        </section>
            

    </div>
   <?php

   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/widgets.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>