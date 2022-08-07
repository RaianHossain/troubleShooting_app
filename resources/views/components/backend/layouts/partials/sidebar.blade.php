<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Administration</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Masterdata
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('roles.index') }}">Role</a>
                                    <a class="nav-link" href="{{ route('users.index') }}">User</a>
                                    <a class="nav-link" href="{{ route('issues.index') }}">Issues</a>
                                    <a class="nav-link" href="{{ route('bids.index') }}">Bids</a>
                                    <a class="nav-link" href="{{ route('winners.index') }}">Winners</a>
                                    <a class="nav-link" href="{{ route('resolves.index') }}">Resolves</a>
                                    <a class="nav-link" href="{{ route('issueResolves.index') }}">History</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Issue Management
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Issues
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ route('issues.pendingIndex') }}">Pending Issues</a>
                                            <a class="nav-link" href="{{ route('issues.runningIndex') }}">Running Issues</a>
                                            <a class="nav-link" href="{{ route('issues.doneIndex') }}">Done Issues</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        My desk
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ route('issues.myUploaded', ['user_id' => 1]) }}">My Uploaded</a>
                                            <a class="nav-link" href="{{ route('issues.mySolved', ['user_id' => 1]) }}">My Solved</a>
                                            <a class="nav-link" href="{{ route('issues.myBidded', ['user_id' => 1]) }}">My Bidded</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Usage</div>
                            <a class="nav-link" href="{{ route('issues.pendingIndex') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Bid
                            </a>
                            <a class="nav-link" href="{{ route('resolving_now') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Resolving Now
                            </a>
                            <a class="nav-link" href="{{ route('task_to_assign') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tasks To Assign
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Report
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>