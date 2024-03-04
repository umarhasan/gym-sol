<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GYMSOL</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('/admin')}}/vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="{{asset('/admin')}}/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="{{asset('/admin')}}/vendors/css/vendor.bundle.addons.css">
  
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('/admin')}}/css/style.css">
  <!-- toastr -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('/admin')}}/vendors/summernote/dist/summernote-bs4.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="http://www.urbanui.com/" />
  <link rel="stylesheet" href="{{asset('/admin')}}/vendors/lightgallery/css/lightgallery.css">
  <style>
      .sidebar .nav .nav-item.active > .nav-link:hover i,.sidebar .nav .nav-item.active > .nav-link:hover span  {
            color: #222b34 !important;
        }
        .sidebar .nav:not(.sub-menu) > .nav-item:hover:not(.nav-profile) > .nav-link {
            background: #f6f6f6;
            color: #222b34;
        }
        .sidebar .nav .nav-item .nav-link:hover i.menu-icon{
            color:#222b34;
        }
        .sidebar .nav .nav-item .nav-link:hover i.menu-arrow:before{
            color:#222b34;
        }
        .sidebar .nav .nav-item .nav-link i.menu-arrow:before{
            color:#f6f6f6;
        }
  </style>
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index-2.html"><img src="{{asset('/admin')}}/images/logo/logo.png" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index-2.html"><img src="{{asset('/admin')}}/images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="fas fa-bars"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="{{ asset('uploads/user/' . auth()->user()->image) }}" alt="Profile">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="fas fa-cog text-primary"></i>
                Settings
              </a>
              <a href="{{ url('/profile')}}" class="dropdown-item">
              <i class="fa-solid fa-user text-primary"></i>
                Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{url('/logout')}}" class="dropdown-item">
                <i class="fas fa-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image">
                  <img src="{{asset('/admin')}}/images/faces/face5.jpg" alt="image"/>
                </div>
                <div class="profile-name">
                  <p class="name">
                    Welcome {{auth::user()->name}}
                  </p>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/dashboard')}}">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            @can('role-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Manage Roles</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('roles.index')}}">List Roles</a></li>
                  @can('role-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('roles.create')}}">Add Role</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('permission-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#permission-layouts" aria-expanded="false" aria-controls="permission-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Permission List</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="permission-layouts">
                <ul class="nav flex-column sub-menu">
                  
                  <li class="nav-item"> <a class="nav-link" href="{{route('permission.index')}}">List Permission</a></li>
                  @can('permission-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('permission.create')}}">Add Permission</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('member-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#member-layouts" aria-expanded="false" aria-controls="member-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Member List</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="member-layouts">
                <ul class="nav flex-column sub-menu">
                  
                  <li class="nav-item"> <a class="nav-link" href="{{route('member.index')}}">List Member</a></li>
                  @can('member-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('member.create')}}">Add Member</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
           
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#fees-collections-layouts" aria-expanded="false" aria-controls="fees-collections-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Fees Collections</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="fees-collections-layouts">
                <ul class="nav flex-column sub-menu">
                  
                  <li class="nav-item"> <a class="nav-link" href="{{route('fees-collections')}}">Fees Collections</a></li>
                 
                </ul>
              </div>
            </li>
        
            @can('staff-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#staff-layouts" aria-expanded="false" aria-controls="staff-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Staff List</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="staff-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('staff.index')}}">List staff</a></li>
                  @can('staff-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('staff.create')}}">Add staff</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('attendance-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#attendance-layouts" aria-expanded="false" aria-controls="attendance-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Attendance</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="attendance-layouts">
                <ul class="nav flex-column sub-menu">
                  
                  <li class="nav-item"> <a class="nav-link" href="{{route('attendance.index')}}">List Attendance</a></li>
                  @can('attendance-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('attendance.create')}}">Add Attendance</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('leads-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#leads-layouts" aria-expanded="false" aria-controls="leads-layouts">
                <i class="fab fa-trello menu-icon"></i>
                <span class="menu-title">Leads</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="leads-layouts">
                <ul class="nav flex-column sub-menu">
                    @can('leads-status-list')
                      <li class="nav-item"> <a class="nav-link" href="{{route('leadStatus.index')}}">Leads Status</a></li>
                    @endcan
                    @can('leads-sources-list')
                      <li class="nav-item"><a class="nav-link" href="{{route('leadSources.index')}}">Lead Sources</a></li>
                    @endcan
                    @can('leads-list')
                      <li class="nav-item"> <a class="nav-link" href="{{route('leads.index')}}">Leads</a></li>
                    @endcan
                    @can('leads-pick')
                    <li class="nav-item"><a class="nav-link" href="{{route('leads.pick')}}">Leads Pick</a></li>
                    @endcan
                    @can('leads-invoice')
                    <li class="nav-item"><a class="nav-link" href="{{route('leads.invoice')}}">Leads Invoice</a></li>
                    @endcan
                  </ul>
              </div>
            </li>
            @endcan
            @can('user-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#user-layouts" aria-expanded="false" aria-controls="user-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage Users</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="user-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('users.index')}}">List Users</a></li>
                  @can('user-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('users.create')}}">Add User</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('shift-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#shift-layouts" aria-expanded="false" aria-controls="shift-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage Shift</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="shift-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('shift.index')}}">List Shift</a></li>
                  @can('shift-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('shift.create')}}">Add Shift</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('leaves-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#leaves-layouts" aria-expanded="false" aria-controls="leaves-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage leaves</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="leaves-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('leaves.index')}}">List leaves</a></li>
                  @can('leaves-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('leaves.create')}}">Add leaves</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('department-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#department-layouts" aria-expanded="false" aria-controls="department-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage department</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="department-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('department.index')}}">List Department</a></li>
                  @can('department-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('department.create')}}">Add Department</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan        
            @can('client-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#client-layouts" aria-expanded="false" aria-controls="client-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage Client</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="client-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('client.index')}}">List Client</a></li>
                  @can('client-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('client.create')}}">Add Client</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('project-list')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#project-layouts" aria-expanded="false" aria-controls="project-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Manage Projects</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="project-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('project.index')}}">List Project</a></li>
                  @can('project-create')
                  <li class="nav-item"> <a class="nav-link" href="{{route('project.create')}}">Add Project</a></li>
                  @endcan
                </ul>
              </div>
            </li>
            @endcan
            @can('mail-inbox')
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#mail-layouts" aria-expanded="false" aria-controls="mail-layouts">
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Mailbox</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="mail-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="{{route('mail.index')}}">Mail</a></li>
                </ul>
              </div>
            </li>
            @endcan

            <li class="nav-item">
            <a href="{{url('/logout')}}" class="nav-link">
                  <i class="fa fa-users menu-icon"></i>
                  <span class="menu-title">Logout</span>
                </a>  
            </li>
          </ul>
        </nav>
        <!-- partial -->
        @yield('content')
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="far fa-heart text-danger"></i></span>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <script src="{{asset('/admin')}}/vendors/js/vendor.bundle.base.js"></script>
  <script src="{{asset('/admin')}}/vendors/js/vendor.bundle.addons.js"></script>
  <script src="{{asset('/admin')}}/js/off-canvas.js"></script>
  <script src="{{asset('/admin')}}/js/hoverable-collapse.js"></script>
  <script src="{{asset('/admin')}}/js/misc.js"></script>
  <script src="{{asset('/admin')}}/js/settings.js"></script>
  <script src="{{asset('/admin')}}/js/todolist.js"></script>
  <script src="{{asset('/admin')}}/vendors/lightgallery/js/lightgallery-all.min.js"></script>
  <script src="{{asset('/admin')}}/js/light-gallery.js"></script>
  <script src="{{asset('/admin')}}/js/dashboard.js"></script>
  <script src="{{asset('/admin')}}/js/data-table.js"></script>
  <script src="{{asset('/admin')}}/vendors/summernote/dist/summernote-bs4.min.js"></script>
  <script src="{{asset('/admin')}}/js/select2.js"></script>
  <script src="{{asset('/admin')}}/js/file-upload.js"></script>
  <script src="{{asset('/admin')}}/js/typeahead.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
  @if(Session::has('success'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

</script>
<script>

  $('.summernoteExample').summernote();
</script>
@stack('js')
</body>
<script>
function assign_users(){
  $.ajax({
    url: "{{route('user.fetch')}}",
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      jQuery.each(data.users, function(index, item) 
      {
          $('<option/>').val(item.id).text(item.name).appendTo('#assign_user');
      });
    }
  });
}

function assign_clients(){
  $.ajax({
    url: "{{route('clients.fetch')}}",
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      jQuery.each(data.clients, function(index, item) 
      {
          $('<option/>').val(item.id).text(item.company_name).appendTo('#assign_client');
      });
    }
  });
}

function assign_projects(){
  $.ajax({
    url: "{{route('projects.fetch')}}",
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      jQuery.each(data.projects, function(index, item) 
      {
          $('<option/>').val(item.id).text(item.name).appendTo('#assign_project');
      });
    }
  });
}


assign_users();
assign_clients();
assign_projects();


</script>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( ".new-item-drop, .complete-item-drop, .process-item-drop, .test-item-drop" ).sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
      receive: function(event, ui) {
                    // $(".container").css("background-color", "red");
            }
    }).disableSelection();

    $( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
        var panddingArr = [];
        var completeArr = [];

        $(".new-item-drop #wrapper").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });
        $(".process-item-drop #wrapper").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });
        $(".test-item-drop #wrapper").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });

        $(".complete-item-drop #wrapper").each(function( index ) {
          completeArr[index] = $(this).attr('item-id');
        });

        /* $.ajax({
            url: "{{ route('task.update',1) }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {panddingArr:panddingArr,completeArr:completeArr},
            success: function(data) {
              console.log('success');
            }
        }); */
          
    });
  });
</script>
</html>