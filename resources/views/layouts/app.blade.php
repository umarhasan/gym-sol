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
    .sidebar .nav .nav-item.active>.nav-link:hover i,
    .sidebar .nav .nav-item.active>.nav-link:hover span {
      color: #fff !important;
    }

/* Style for custom scrollbar */
.scrollbar-wrapper {
    max-height: calc(100vh - 60px); /* Adjust height as needed */
    overflow-y: auto;
    /* scrollbar-width: thin; For Firefox */
  }

  .scrollbar-wrapper::-webkit-scrollbar {
    width: 8px; /* Width of the scrollbar */
  }

  .scrollbar-wrapper::-webkit-scrollbar-thumb {
    background-color: #888; /* Color of the scrollbar thumb */
    border-radius: 2px; /* Rounded corners of the thumb */
  }

  .scrollbar-wrapper::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Hover color of the thumb */
  }

  .scrollbar-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color of the scrollbar track */
    border-radius: 4px; /* Rounded corners of the track */
  }

/* Active menu item */
.nav-item.active > .nav-link {
    background-color: #392c70;
    color: white;
}

/* Active submenu item */
.nav-item.active .sub-menu .nav-item .nav-link.active {
    /*background-color: black;*/
    color: #f1dc5c;
}

/* Active menu item */
/*.nav-item.active > .nav-link {*/
/*  background-color: black;*/
/*  color: white;*/
/*}*/

/* Active submenu item */
/*.nav-item.active .sub-menu .nav-item.active > .nav-link {*/
/*  background-color: black;*/
/*  color: white;*/
/*}*/

  </style>
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" >

        @if(auth()->user()->club && auth()->user()->id == auth()->user()->club->user_id)
        <a class="navbar-brand brand-logo" href="index-2.html"><img src="{{ asset('uploads/club-logo/' . auth()->user()->club->logo) }}" alt="logo" /></a>
        @else
       <a class="navbar-brand brand-logo" href="index-2.html"><img src="{{asset('/admin')}}/images/logo/logo.png" alt="logo" /></a>
      @endif
        <a class="navbar-brand brand-logo-mini" href="index-2.html"><img src="{{asset('/admin')}}/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="fas fa-bars"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
        <!--Start Log Error-->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Log Error</button>
        <!--End Log Error-->
        
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            
                    @if(auth()->check() && auth()->user()->image && auth()->user()->image)
                        <img src="{{ asset('uploads/user/' . auth()->user()->image) }}" alt="Profile">
                    @else
                        <img src="{{ asset('admin/images/logo/profile.jpg') }}" alt="Profile">
                    @endif
                   
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
    <!-- Modal -->
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar" >
          <div class="scrollbar-wrapper"> 
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/dashboard')}}">
                      <i class="fa fa-home menu-icon"></i>
                      <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                @can('role-list')
                <li class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') ? 'active' : '' }}" data-toggle="collapse" href="#roles-page-layouts" aria-expanded="false" aria-controls="roles-page-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Manage Roles</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') ? 'show' : '' }}" id="roles-page-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">List Roles</a>
                            </li>
                            @can('role-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('roles.create') ? 'active' : '' }}" href="{{ route('roles.create') }}">Add Role</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
            
                @can('permission-list')
                <li class="nav-item {{ request()->is('permission*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('permission.index') || request()->routeIs('permission.create') ? 'active' : '' }}" data-toggle="collapse" href="#permissions-page-layouts" aria-expanded="false" aria-controls="permissions-page-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Manage Permissions</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('permission.index') || request()->routeIs('permission.create') ? 'show' : '' }}" id="permissions-page-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('permission.index') ? 'active' : '' }}" href="{{ route('permission.index') }}">List Permissions</a>
                            </li>
                            @can('permission-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('permission.create') ? 'active' : '' }}" href="{{ route('permission.create') }}">Add Permission</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @can('member-list')
                <li class="nav-item {{ request()->routeIs('member.index') || request()->routeIs('member.create') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('member.index') || request()->routeIs('member.create') ? 'active' : '' }}" data-toggle="collapse" href="#member-layouts" aria-expanded="false" aria-controls="member-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Member List</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('member.index') || request()->routeIs('member.create') ? 'show' : '' }}" id="member-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('member.index') ? 'active' : '' }}" href="{{ route('member.index') }}">List Member</a>
                            </li>
                            @can('member-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('member.create') ? 'active' : '' }}" href="{{ route('member.create') }}">Add Member</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

    
                @can('fees-collection')
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#feescollections-layouts" aria-expanded="false" aria-controls="feescollections-layouts">
                      <i class="fab fa-trello menu-icon"></i>
                      <span class="menu-title">Fees Collections</span>
                      <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="feescollections-layouts">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('fees-collections')}}">Fees Collections</a></li>
                      </ul>
                    </div>
                  </li>
                @endcan
        
                @can('staff-list')
                <li class="nav-item {{ request()->routeIs('staff.index') || request()->routeIs('staff.create') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('staff.index') || request()->routeIs('staff.create') ? 'active' : '' }}" data-toggle="collapse" href="#staff-layouts" aria-expanded="false" aria-controls="staff-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Staff List</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('staff.index') || request()->routeIs('staff.create') ? 'show' : '' }}" id="staff-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}" href="{{ route('staff.index') }}">List Staff</a>
                            </li>
                            @can('staff-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('staff.create') ? 'active' : '' }}" href="{{ route('staff.create') }}">Add Staff</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @can('user-list')
                <li class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('users.create') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('users.create') ? 'active' : '' }}" data-toggle="collapse" href="#user-layouts" aria-expanded="false" aria-controls="user-layouts">
                        <i class="fa fa-users menu-icon"></i>
                        <span class="menu-title">Manage Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('users.create') ? 'show' : '' }}" id="user-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">List Users</a>
                            </li>
                            @can('user-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">Add User</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
            
                @can('department-list')
                <li class="nav-item {{ request()->routeIs('department.*') || request()->routeIs('department.create') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('department.*') || request()->routeIs('department.create') ? 'active' : '' }}" data-toggle="collapse" href="#department-layouts" aria-expanded="false" aria-controls="department-layouts">
                        <i class="fa fa-users menu-icon"></i>
                        <span class="menu-title">Manage Department</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('department.*') || request()->routeIs('department.create') ? 'show' : '' }}" id="department-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('department.index') ? 'active' : '' }}" href="{{ route('department.index') }}">List Department</a>
                            </li>
                            @can('department-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('department.create') ? 'active' : '' }}" href="{{ route('department.create') }}">Add Department</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
            
                @can('client-list')
                <li class="nav-item {{ request()->routeIs('client.*') || request()->routeIs('client.create') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('client.*') || request()->routeIs('client.create') ? 'active' : '' }}" data-toggle="collapse" href="#client-layouts" aria-expanded="false" aria-controls="client-layouts">
                        <i class="fa fa-users menu-icon"></i>
                        <span class="menu-title">Manage Client</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('client.*') || request()->routeIs('client.create') ? 'show' : '' }}" id="client-layouts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('client.index') ? 'active' : '' }}" href="{{ route('client.index') }}">List Client</a>
                            </li>
                            @can('client-create')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('client.create') ? 'active' : '' }}" href="{{ route('client.create') }}">Add Client</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                
                @can('expenses-list')
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#expenses-layouts" aria-expanded="false" aria-controls="expenses-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Expenses</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="expenses-layouts">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="{{route('expenses.index')}}">Expenses</a></li>
                        </ul>
                      </div>
                  </li>
                @endcan
                
                @can('settings')
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="collapse" href="#settings-layouts" aria-expanded="false" aria-controls="settings-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Settings</span>
                        <i class="menu-arrow"></i>
                      </a>
                      <div class="collapse" id="settings-layouts">
                        <ul class="nav flex-column sub-menu">
                          <li class="nav-item"> <a class="nav-link" href="{{route('club.create')}}">Settings</a></li>
                        </ul>
                      </div>
                  </li>
                @endcan
                
                @can('reports')
                <li class="nav-item {{ request()->routeIs('members.*') || request()->routeIs('collections.*') || request()->routeIs('expenses.reports') || request()->routeIs('profit_loss') ? 'active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#reports-layouts" aria-expanded="false" aria-controls="reports-layouts">
                        <i class="fab fa-trello menu-icon"></i>
                        <span class="menu-title">Reports</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="reports-layouts">
                        <ul class="nav flex-column sub-menu">
                            @can('unpaid-members')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('members.unpaid') ? 'active' : '' }}" href="{{ route('members.unpaid') }}">Unpaid Members</a>
                            </li>
                            @endcan
                            @can('expired-members')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('members.expired') ? 'active' : '' }}" href="{{ route('members.expired') }}">Expired Members</a>
                            </li>
                            @endcan
                            @can('soon-expire-members')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('members.expired.soon') ? 'active' : '' }}" href="{{ route('members.expired.soon') }}">Expiring Soon (1-8 Days)</a>
                            </li>
                            @endcan
                            @can('collections-history')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('collections.history') ? 'active' : '' }}" href="{{ route('collections.history') }}">Collection History</a>
                            </li>
                            @endcan
                            @can('expenses-history')
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('expenses.reports') ? 'active' : '' }}" href="{{ route('expenses.reports') }}">Expenses History</a>
                            </li>
                            @endcan
                            
                            @can('profit-and-loss')
                            
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('profit_loss') ? 'active' : '' }}" href="{{ route('profit_loss') }}">Profit and Loss</a>
                            </li>
                            @endcan
                            
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
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error Log Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                        <table id="order-listing" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                            <thead style="background-color: #F8F8F8;">
                            <tr>
                                <th>Message</th>
                            </tr>
                        </thead>
                            @php 
                                $importHistories = App\Models\ImportHistory::get();
                            @endphp
                            
                            @if($importHistories)
                                @php
                                $i = 0;
                                @endphp
                                @foreach($importHistories as $key =>  $importHistory)
                                  @php $i++; 
                                  @endphp
                                    <tr>
                                        <td>{{ $importHistory->error_message }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            
        </div>
        </div>
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
    toastr.options = {
      "closeButton": true,
      "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
      "closeButton": true,
      "progressBar": true
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
  function assign_users() {
    $.ajax({
      url: "{{route('user.fetch')}}",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        jQuery.each(data.users, function(index, item) {
          $('<option/>').val(item.id).text(item.name).appendTo('#assign_user');
        });
      }
    });
  }

  function assign_clients() {
    $.ajax({
      url: "{{route('clients.fetch')}}",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        jQuery.each(data.clients, function(index, item) {
          $('<option/>').val(item.id).text(item.company_name).appendTo('#assign_client');
        });
      }
    });
  }

  function assign_projects() {
    $.ajax({
      url: "{{route('projects.fetch')}}",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        jQuery.each(data.projects, function(index, item) {
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
  $(function() {
    $(".new-item-drop, .complete-item-drop, .process-item-drop, .test-item-drop").sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
      receive: function(event, ui) {
        // $(".container").css("background-color", "red");
      }
    }).disableSelection();

    $(".connectedSortable").on("sortupdate", function(event, ui) {
      var panddingArr = [];
      var completeArr = [];

      $(".new-item-drop #wrapper").each(function(index) {
        panddingArr[index] = $(this).attr('item-id');
      });
      $(".process-item-drop #wrapper").each(function(index) {
        panddingArr[index] = $(this).attr('item-id');
      });
      $(".test-item-drop #wrapper").each(function(index) {
        panddingArr[index] = $(this).attr('item-id');
      });

      $(".complete-item-drop #wrapper").each(function(index) {
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