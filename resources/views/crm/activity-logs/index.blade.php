@extends('crm/layouts/master')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="pb-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Activity Logs</h4>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form action="#" method="get">
                                <div class="d-flex justify-content-between">
                                    <div class="row">
                                        <div class="col-xl-10 col-md-10 col-sm-10">
                                            <div class="search-box">
                                                <input type="text" name="search" value=""
                                                    class="form-control search" placeholder="Search User Name, Role">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="submit" class="btn btn-primary waves ripple-light">
                                                    <!-- <span class="d-none d-md-inline-flex"> Search </span> -->
                                                    <i class="fa-solid fa-magnifying-glass "></i>

                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <!-- <span class="d-none d-md-inline-flex"> Sort </span> -->
                                                <i class="fa-solid fa-arrow-up-z-a "></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Sort By Date and Time</a></li>
                                                <li><a class="dropdown-item" href="#">Sort By IP Address</a></li>
                                                <!-- <li><a class="dropdown-item" href="#">Sort By Ratings</a></li>  -->
                                            </ul>
                                        </div>

                                        <!-- <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-group" role="group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                                <span class="d-none d-md-inline-flex"> Filters </span>
                                                <i class="fa-solid fa-filter "></i>
                                            </button>
                                        </div> -->
                                    </div>
                                    <div class="modal fade" id="standard-modal" tabindex="-1"
                                        aria-labelledby="standard-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="standard-modalLabel">Filters</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body px-3 py-md-2">
                                                    <h5>Industry Type</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="flexCheckDefault">
                                                                    <label class="form-check-label" for="flexCheckDefault">
                                                                        Pharma
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="hardware">
                                                                    <label class="form-check-label" for="hardware">
                                                                        Retail
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="ossupport">
                                                                    <label class="form-check-label" for="ossupport">
                                                                        Manufacturer
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="networking">
                                                                    <label class="form-check-label" for="networking">
                                                                        Healthcare
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h5>Status</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="flexRadioDefault1">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault1">
                                                                        New
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="flexRadioDefault2">
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault2">
                                                                        Lost
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="qualified">
                                                                    <label class="form-check-label" for="qualified">
                                                                        Qualified
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mt-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="unqualified">
                                                                    <label class="form-check-label" for="unqualified">
                                                                        Unqualified
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="nav nav-underline border-bottom pt-2" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active p-2" id="all_customer_tab" data-bs-toggle="tab"
                                        href="#all_customer" role="tab">
                                        <span class="d-block d-sm-none"><i class="mdi mdi-information"></i></span>
                                        <span class="d-none d-sm-block">All Logs</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link p-2" id="active_customer_tab" data-bs-toggle="tab" href="#active_customer"
                                        role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-sitemap-outline"></i></span>
                                        <span class="d-none d-sm-block">Active Customer</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="banned_customers_tab" data-bs-toggle="tab"
                                        href="#banned_customers" role="tab">
                                        <span class="d-block d-sm-none"><i
                                                class="mdi mdi-sitemap-outline"></i></span>
                                        <span class="d-none d-sm-block">Banned Customer</span>
                                    </a>
                                </li> -->
                            </ul>

                            <div class="tab-content text-muted">

                                <div class="tab-pane active show pt-4" id="all_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="activity-logs-table"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>User</th>
                                                                <th>Role</th>
                                                                <th>Action</th>
                                                                <th>Module</th>
                                                                <th>Date & Time</th>
                                                                <th>IP Address</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($activities as $activity)
                                                                <tr>
                                                                    <td>
                                                                        @if ($activity->causer)
                                                                            {{ $activity->causer->name ?? ($activity->causer->email ?? 'N/A') }}
                                                                        @else
                                                                            System
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($activity->causer && $activity->causer->roles->isNotEmpty())
                                                                            {{ $activity->causer->roles->pluck('name')->join(', ') }}
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge
                                                                    @if ($activity->event == 'created') bg-success
                                                                    @elseif($activity->event == 'updated') bg-primary
                                                                    @elseif($activity->event == 'deleted') bg-danger
                                                                    @else bg-secondary @endif">
                                                                            {{ ucfirst($activity->event) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        {{ $activity->description ?? class_basename($activity->subject_type ?? 'N/A') }}
                                                                    </td>
                                                                    <td>{{ $activity->created_at->format('Y-m-d h:i A') }}
                                                                    </td>
                                                                    <td>{{ $activity->properties['ip'] ?? request()->ip() }}
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No activity
                                                                        logs found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                    <!-- Pagination -->
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div>
                                                            Showing {{ $activities->firstItem() ?? 0 }} to
                                                            {{ $activities->lastItem() ?? 0 }} of {{ $activities->total() }}
                                                            entries
                                                        </div>
                                                        <div>
                                                            {{ $activities->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end Experience -->

                                <div class="tab-pane pt-4" id="active_customer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Username</th>
                                                                <th>Email</th>
                                                                <th>Contact Number</th>
                                                                <th>Number of Orders</th>
                                                                <th>Status</th>
                                                                <th>Joined At</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td>Emma Martinez</td>
                                                                <td>UX/UI Designer</td>
                                                                <td>Portland</td>
                                                                <td>29</td>
                                                                <td>2023-09-05</td>
                                                                <td>29</td>
                                                                <td>2023-09-05</td>
                                                                <td>$90,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>William Clark</td>
                                                                <td>Software Developer</td>
                                                                <td>Boston</td>
                                                                <td>28</td>
                                                                <td>2023-05-28</td>
                                                                <td>28</td>
                                                                <td>2023-05-28</td>
                                                                <td>$115,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ava Taylor</td>
                                                                <td>Content Writer</td>
                                                                <td>Philadelphia</td>
                                                                <td>26</td>
                                                                <td>2022-10-22</td>
                                                                <td>26</td>
                                                                <td>2022-10-22</td>
                                                                <td>$70,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Joseph White</td>
                                                                <td>Project Coordinator</td>
                                                                <td>Dallas</td>
                                                                <td>31</td>
                                                                <td>2023-02-15</td>
                                                                <td>31</td>
                                                                <td>2023-02-15</td>
                                                                <td>$85,000</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end Experience -->

                                <div class="tab-pane pt-4" id="banned_customers" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <!-- <div class="card-header">
                                                                <h5 class="card-title mb-0">Tables</h5>
                                                            </div>
                                                            -->
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Username</th>
                                                                <th>Email</th>
                                                                <th>Contact Number</th>
                                                                <th>Number of Orders</th>
                                                                <th>Status</th>
                                                                <th>Joined At</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td>Jessica Thompson</td>
                                                                <td>HR Specialist</td>
                                                                <td>Miami</td>
                                                                <td>30</td>
                                                                <td>2023-01-25</td>
                                                                <td>30</td>
                                                                <td>2023-01-25</td>
                                                                <td>$80,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Matthew Lee</td>
                                                                <td>Data Scientist</td>
                                                                <td>Denver</td>
                                                                <td>34</td>
                                                                <td>2022-11-08</td>
                                                                <td>34</td>
                                                                <td>2022-11-08</td>
                                                                <td>$130,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Olivia Garcia</td>
                                                                <td>Graphic Designer</td>
                                                                <td>Atlanta</td>
                                                                <td>27</td>
                                                                <td>2023-07-20</td>
                                                                <td>27</td>
                                                                <td>2023-07-20</td>
                                                                <td>$75,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>James Hernandez</td>
                                                                <td>Business Analyst</td>
                                                                <td>Phoenix</td>
                                                                <td>32</td>
                                                                <td>2023-03-12</td>
                                                                <td>32</td>
                                                                <td>2023-03-12</td>
                                                                <td>$100,000</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end education -->

                                <div class="tab-pane pt-4" id="technicians" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow-none">
                                                <!-- <div class="card-header">
                                                                <h5 class="card-title mb-0">Tables</h5>
                                                            </div>
                                                            -->
                                                <div class="card-body">
                                                    <table id="responsive-datatable"
                                                        class="table table-striped table-borderless dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Position</th>
                                                                <th>Office</th>
                                                                <th>Age</th>
                                                                <th>Start date</th>
                                                                <th>Salary</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Chloe Nguyen</td>
                                                                <td>Product Designer</td>
                                                                <td>Minneapolis</td>
                                                                <td>28</td>
                                                                <td>2023-02-20</td>
                                                                <td>$120,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>William Kim</td>
                                                                <td>HR Manager</td>
                                                                <td>Orlando</td>
                                                                <td>33</td>
                                                                <td>2022-09-25</td>
                                                                <td>$100,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Emily King</td>
                                                                <td>Data Engineer</td>
                                                                <td>Salt Lake City</td>
                                                                <td>30</td>
                                                                <td>2023-04-10</td>
                                                                <td>$125,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nicholas Thomas</td>
                                                                <td>Business Development Manager</td>
                                                                <td>Tampa</td>
                                                                <td>27</td>
                                                                <td>2023-11-28</td>
                                                                <td>$95,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Oliver Martinez</td>
                                                                <td>Software Tester</td>
                                                                <td>Austin</td>
                                                                <td>34</td>
                                                                <td>2023-08-15</td>
                                                                <td>$115,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sophia Brown</td>
                                                                <td>UX/UI Developer</td>
                                                                <td>Washington D.C.</td>
                                                                <td>31</td>
                                                                <td>2022-07-10</td>
                                                                <td>$90,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Liam Wilson</td>
                                                                <td>Content Manager</td>
                                                                <td>San Jose</td>
                                                                <td>28</td>
                                                                <td>2023-12-22</td>
                                                                <td>$75,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Charlotte Garcia</td>
                                                                <td>Project Analyst</td>
                                                                <td>Detroit</td>
                                                                <td>33</td>
                                                                <td>2023-05-05</td>
                                                                <td>$110,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ethan Wright</td>
                                                                <td>Technical Writer</td>
                                                                <td>Indianapolis</td>
                                                                <td>30</td>
                                                                <td>2023-01-20</td>
                                                                <td>$80,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Isabella Baker</td>
                                                                <td>Systems Administrator</td>
                                                                <td>Charlotte</td>
                                                                <td>27</td>
                                                                <td>2023-09-18</td>
                                                                <td>$105,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>James Hall</td>
                                                                <td>Marketing Coordinator</td>
                                                                <td>San Francisco</td>
                                                                <td>34</td>
                                                                <td>2022-06-15</td>
                                                                <td>$95,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Emma Young</td>
                                                                <td>Product Owner</td>
                                                                <td>Denver</td>
                                                                <td>29</td>
                                                                <td>2022-11-30</td>
                                                                <td>$120,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Aiden Evans</td>
                                                                <td>Business Consultant</td>
                                                                <td>Seattle</td>
                                                                <td>32</td>
                                                                <td>2023-04-05</td>
                                                                <td>$100,000</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end education -->


                            </div> <!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
