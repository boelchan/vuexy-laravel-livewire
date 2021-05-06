@extends('layouts/contentLayoutMaster')

@section('title', 'User')

@section('content')

<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Data</h4>
                    <div class="heading-elements mb-0">
                        <ul class="list-inline mb-0">
                            <li> <a data-toggle="collapse" data-target="#collapseFilter"><i class="fas fa-search fa-lg"></i></a> </li>
                            <li> <a class="btn-create" data-route="{{ route('user.create') }}"><i class="fas fa-plus fa-lg"></i></a> </li>
                        </ul>
                    </div>
                </div>
                <!--Search Form -->
                <div class="collapse-margin ml-2 mr-2" id="accordionExample">
                    <div class="card">
                        <div id="collapseFilter" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                            <div class="card-body">
                                <h5>Filter</h5>
                                <div class="form-row mb-1">
                                    <div class="col-lg-4">
                                        <label>Name:</label>
                                        <input type="text" name="fname" class="filter form-control dt-input"  placeholder="Alaric Beslier"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Email:</label>
                                        <input type="text" name="femail" class="filter form-control dt-input"  placeholder="demo@example.com"/>
                                    </div>                  
                                </div>
                                <div>
                                    <button class="submit-filter btn btn-success btn-sm" value="submit"><i class="fas fa-search"></i> Cari</button>
                                    <button class="submit-filter btn btn-outline-danger btn-sm" value="reset"><i class="fas fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-datatable">
                    <table class="dt-advanced-search table" id="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('page-script')

<script>
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : '{!! route('user.data_list') !!}',
            data: function (d) {
                d.name  = $('input[name=fname]').val();
                d.email = $('input[name=femail]').val();
            },
        },
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        select: true,

        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('.submit-filter').on('click', function(e) {
        if ($(this).val() == 'reset') $('.filter').val('');
        table.draw();
    });
</script>
  
@endsection