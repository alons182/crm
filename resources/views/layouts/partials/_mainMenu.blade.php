<aside class="sidebar canvas-left bg-dark">
                <!-- main navigation -->
                <nav class="main-navigation">
                    <ul>
                        <li>
                            <a href="{!! URL::route('dashboard') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Panel de Control</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{!! URL::route('clients') !!}">
                                <i class="fa fa-folder"></i>
                                <span>Clientes</span>
                            </a>
                        </li>
                        
                        @can('create_sellers')
                        <li>
                            <a href="{!! URL::route('sellers') !!}">
                                <i class="fa fa-coffee"></i>
                                <span>Vendedores</span>
                            </a>
                        </li>
                        @endcan
                        @can('authorize_property')
                        <li>
                            <a href="{!! URL::route('projects') !!}">
                                <i class="fa fa-home"></i>
                                <span>Proyectos</span>
                            </a>
                        </li>
                       @endcan
                       @can('authorize_banks')
                        <li>
                            <a href="{!! URL::route('banks') !!}">
                                <i class="fa fa-home"></i>
                                <span>Requisitos de Bancos</span>
                            </a>
                        </li>
                       @endcan
                       @can('create_sellers')
                        <li class="dropdown show-on-hover">
                            <a href="#" data-toggle="dropdown">
                                <i class="fa fa-file"></i>
                                <span>Reportes</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{!! URL::route('r_tracing') !!}">
                                        <span>Seguimiento</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Ventas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        @endcan

                    </ul>
                </nav>
                <!-- /main navigation -->


                <!-- footer -->
                <footer>
                    <div class="about-app pd-md animated pulse">
                        <a href="#">
                            <img src="/img/avotz.png" alt="Avotz">
                        </a>
                        <span>
                            <b>This</b> is a system admin created in Laravel by Avotz .
                            <a href="http://avotz.com">
                                <b>Find out more</b>
                            </a>
                        </span>
                    </div>

                    <div class="footer-toolbar pull-left">
                        <a href="#" class="pull-left help">
                            <i class="fa fa-question-circle"></i>
                        </a>

                        <a href="#" class="toggle-sidebar pull-right hidden-xs">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                </footer>
                <!-- /footer -->
            </aside>
