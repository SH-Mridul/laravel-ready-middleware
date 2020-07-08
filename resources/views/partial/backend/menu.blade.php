   <div id="layoutSidenav_nav">
       <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
           <div class="sb-sidenav-menu">
               <div class="nav">
                   <div class="sb-sidenav-menu-heading">Core</div>
                   <a class="nav-link {{Request::is('/home')? 'active' : ''}}" href="{{url('/home')}}">
                       <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                       Dashboard
                   </a>



                   <div class="sb-sidenav-menu-heading">Roles And Permissions</div>
                   <a class="nav-link collapsed  {{Request::is('roleView')||Request::is('moduleView')||Request::is('routeView') ||Request::is('roleUserView')||Request::is('assignedRoleView') || Request::is('roleModuleAssignView')||Request::is('assignedModuleView') ? 'active' : ''}}"
                            href="#" data-toggle="collapse" data-target="#collapseRoles"
                       aria-expanded="false" aria-controls="collapseRole">
                       <div class="sb-nav-link-icon"><i class="fas fa-grip-horizontal"></i></div>
                       Role & Permissions
                       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                   </a>

                   {{-- {{Request::is('addSupplier')|| Request::is('supplierView') ? 'active' : ''}} --}}

                   <div class="collapse" id="collapseRoles" aria-labelledby="headingOne"
                       data-parent="#sidenavAccordion">
                       <nav class="sb-sidenav-menu-nested nav">
                           <a class="nav-link  {{Request::is('roleView') ? 'active' : ''}}" href="{{ url('roleView') }}">Roles</a>
                           <a class="nav-link  {{Request::is('moduleView') ? 'active' : ''}}" href="{{ url('moduleView') }}">Modules</a>
                           <a class="nav-link  {{Request::is('routeView') ? 'active' : ''}}" href="{{ url('routeView') }}">Routes</a>
                           
                            
                           
                                {{-- role assign menu --}}
                            <a class="nav-link {{Request::is('roleUserView')||Request::is('assignedRoleView') ? 'active' : ''}} collapsed" href="#" data-toggle="collapse"
                               data-target="#roleAssignMenu" aria-expanded="false" aria-controls="pagesCollapseAuth">
                               Role Assign
                               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                           </a>
                           <div class="collapse" id="roleAssignMenu" aria-labelledby="headingOne"
                               data-parent="#sidenavAccordionPages">
                               <nav class="sb-sidenav-menu-nested nav">
                                  <a class="nav-link  {{Request::is('roleUserView') ? 'active' : ''}}" href="{{ url('roleUserView') }}">Role Assign</a>
                                  <a class="nav-link  {{Request::is('assignedRoleView') ? 'active' : ''}}" href="{{ url('assignedRoleView') }}">Assigned Role</a>
                               </nav>
                           </div>

                           {{-- end --}}


                           {{-- module assign menu --}}
                            <a class="nav-link {{Request::is('roleModuleAssignView')||Request::is('assignedModuleView') ? 'active' : ''}} collapsed"
                                href="#" data-toggle="collapse" data-target="#moduleAssignMenu" aria-expanded="false"
                                aria-controls="pagesCollapseAuth">
                                Module Assign
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="moduleAssignMenu" aria-labelledby="headingOne"
                                data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link  {{Request::is('roleModuleAssignView') ? 'active' : ''}}"
                                        href="{{ url('roleModuleAssignView') }}">Module Assign</a>
                                    <a class="nav-link  {{Request::is('assignedModuleView') ? 'active' : ''}}"
                                        href="{{ url('assignedModuleView') }}">Assigned Module</a>
                                </nav>
                            </div>
                           {{-- end --}}

                         
                       </nav>
                   </div>



                   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                       aria-expanded="false" aria-controls="collapsePages">
                       <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                       Pages
                       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                   </a>
                   <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                       data-parent="#sidenavAccordion">
                       <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                           <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                               Authentication
                               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                           </a>
                           <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                               data-parent="#sidenavAccordionPages">
                               <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="login.html">Login</a>
                                   <a class="nav-link" href="register.html">Register</a>
                                   <a class="nav-link" href="password.html">Forgot Password</a>
                               </nav>
                           </div>
                           <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#pagesCollapseError" aria-expanded="false"
                               aria-controls="pagesCollapseError">
                               Error
                               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                           </a>
                           <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                               data-parent="#sidenavAccordionPages">
                               <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="401.html">401 Page</a>
                                   <a class="nav-link" href="404.html">404 Page</a>
                                   <a class="nav-link" href="500.html">500 Page</a>
                               </nav>
                           </div>
                       </nav>
                   </div>
                   <div class="sb-sidenav-menu-heading">Addons</div>
                   <a class="nav-link" href="charts.html">
                       <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                       Charts
                   </a>
                   <a class="nav-link" href="tables.html">
                       <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                       Tables
                   </a>
               </div>
           </div>
           <div class="sb-sidenav-footer">
               <div class="small">M.Soft</div>
           </div>
       </nav>
   </div>
