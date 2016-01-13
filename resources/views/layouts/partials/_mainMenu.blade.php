<aside class="sidebar canvas-left bg-dark">
                <!-- main navigation -->
                <nav class="main-navigation">
                    <ul>
                        <li>
                            <a href="{!! URL::route('dashboard') !!}">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{!! URL::route('clients') !!}">
                                <i class="fa fa-folder"></i>
                                <span>Clients</span>
                            </a>
                        </li>
                        
                        @can('create_sellers')
                        <li>
                            <a href="{!! URL::route('sellers') !!}">
                                <i class="fa fa-coffee"></i>
                                <span>Sellers</span>
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="{!! URL::route('properties') !!}">
                                <i class="fa fa-home"></i>
                                <span>Properties</span>
                            </a>
                        </li>
                       

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
