<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark navbar-custom" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading text-white">Core</div>
                            <a class="nav-link text-white" href="{{ route('dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading text-white">Administration</div>
                            @if(!is_Engineer())
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Masterdata
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link text-white" href="{{ route('roles.index') }}">Role</a>
                                    <a class="nav-link text-white" href="{{ route('centers.index') }}">Centers</a>
                                    <a class="nav-link text-white" href="{{ route('engineers.index') }}">Enginners</a>
                                    <a class="nav-link text-white" href="{{ route('users.index') }}">User</a>
                                    <a class="nav-link text-white" href="{{ route('issues.index') }}">Issues</a>
                                    <a class="nav-link text-white" href="{{ route('bids.index') }}">Bids</a>
                                    <a class="nav-link text-white" href="{{ route('winners.index') }}">Winners</a>
                                    <a class="nav-link text-white" href="{{ route('resolves.index') }}">Resolves</a>
                                    <a class="nav-link text-white" href="{{ route('issueResolves.index') }}">History</a>
                                </nav>
                            </div>
                            @endif
                            <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Issue Management
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    @if(!is_Engineer())
                                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Issues
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link text-white" href="{{ route('issues.pendingIndex') }}">Pending Issues</a>
                                            <a class="nav-link text-white" href="{{ route('issues.assignedIndex') }}">Assigned Issues</a>
                                            <a class="nav-link text-white" href="{{ route('issues.runningIndex') }}">Running Issues</a>
                                            <a class="nav-link text-white" href="{{ route('issues.doneIndex') }}">Done Issues</a>
                                        </nav>
                                    </div>
                                    @endif
                                    <a class="nav-link collapsed text-white" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        My desk
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link text-white" href="{{ route('issues.myUploaded', ['user_id' => auth()->user()->id]) }}">My Uploaded</a>
                                            <a class="nav-link text-white" href="{{ route('issues.mySolved', ['user_id' => auth()->user()->id]) }}">My Solved</a>
                                            <a class="nav-link text-white" href="{{ route('issues.myBidded', ['user_id' => auth()->user()->id]) }}">My Bidded</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading text-white">Usage</div>
                            <a class="nav-link text-white" href="{{ route('issues.uploadAnIssue') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Upload an Issue
                            </a>
                            <a class="nav-link text-white" href="{{ route('issues.biddableIssues') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Bid
                            </a>
                            <a class="nav-link text-white" href="{{ route('resolving_now', ['user_id' => auth()->user()->id]) }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Resolving Now
                            </a>
                            <a class="nav-link text-white" href="{{ route('issues.toShip', ['user_id' => auth()->user()->id]) }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Items to ship
                            </a>
                            @if(!is_Engineer())
                            <a class="nav-link text-white" href="{{ route('task_to_assign') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tasks To Assign
                            </a>
                            <a class="nav-link text-white" href="{{ route('issues.force') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Issues For Force Assign
                            </a>
                            <a class="nav-link text-white" href="{{ route('resolves.timeExtendRequest') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Time Extend Request
                            </a>
                            @endif
                            <a class="nav-link text-white" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Report
                            </a>
                            <a class="nav-link text-white" href="{{ route('sendEmail') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Send Email
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer text-white bg-dark">
                        <div class="small">Logged in as:</div>
                        {{ auth()->user()->name ?? null }} - {{ auth()->user()->role->name ?? null }}
                    </div>
                </nav>
            </div>