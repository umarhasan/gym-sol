@extends('layouts.app')


@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Users Management</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Users Management</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="pull-right">
                      @can('user-create')
                        <a class="btn btn-primary" style="margin-bottom:5px" href="{{ route('users.create') }}"> + Add User</a>
                      @endcan
                    </div>
                    <table id="abc" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Roles</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($data)
                        @php
                        $id =1;
                        @endphp
                        @foreach($data as $key => $user)
                        <tr>
                          <td>{{$id++}}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                            @endif
                          </td>
                          <td>
                            <div class="btn-group">
                           
                              @can('user-edit')
                                <a class="btn btn-primary btn-a" href="{{ route('users.edit',$user->id) }}">Edit</a> &nbsp;   
                              @endcan
                              @can('user-permission')
                                <a class="btn btn-primary btn-a" href="{{ route('users.permission',$user->id) }}">User Permission</a>    
                              @endcan
                              @can('user-delete')
                              <form method="post" action="{{route('users.destroy',$user->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Are You Sure Want To Delete This.??')" type="button" class="btn btn-danger btn-b"><i class="fa fa-trash"></i></button>
                              </form>
                              @endcan
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                        {{ $data->appends(request()->input())->links('pagination::bootstrap-4') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#abc').DataTable({
            "paging": true, // Pagination on
            //"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Rows per page menu
            "searching": true, // Search bar on
            "ordering": true, // Sorting on
            "info": true, // Table information (records shown, etc.)
            "autoWidth": false, // Automatic column width calculation off
            // Custom language settings
            //"language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No matching records found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Search:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });
</script>
@endsection