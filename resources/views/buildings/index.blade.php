@extends('layouts.app')

@section('content')
    <section class="container py-5">
        {{-- <h3 class="mb-4">Import Building Addresses</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('building.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Select Excel File</label>
                <input type="file" name="file" id="file" class="form-control" required>
                <small class="text-muted">Allowed: .xlsx, .xls, .csv</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload & Import</button>
        </form> --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Building List</h5>
                <a href="{{ route('building.create') }}" class="btn btn-light btn-sm">+ Add Building</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="buildingTable" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Building</th>
                                <th>District</th>
                                <th>Address</th>
                                <th>Address Chinese</th>
                                <th>Usage</th>
                                <th>Year of Completion</th>
                                <th>Property Type</th>
                                <th>Title</th>
                                <th>Management Company</th>
                                <th>Developers</th>
                                <th>Transportation</th>
                                <th>Floor</th>
                                <th>Floor Area</th>
                                <th>Height</th>
                                <th>A/C System</th>
                                <th>Lifts</th>
                                <th>Parking</th>
                                <th>Carpark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="background-color: #fff;">
        <footer>
            <div class="container social_icon text-center">
                <hr class="font-weight-bold">
                <small class="text-center text-muted">Copyright 2024</small>
            </div>
        </footer>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#buildingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('building.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'building', name: 'building' },
                { data: 'district', name: 'district' },
                { data: 'address', name: 'address' },
                { data: 'address_chinese', name: 'address_chinese' },
                { data: 'usage', name: 'usage' },
                { data: 'year_of_completion', name: 'year_of_completion' },
                { data: 'property_type', name: 'property_type' },
                { data: 'title', name: 'title' },
                { data: 'management_company', name: 'management_company' },
                { data: 'developers', name: 'developers' },
                { data: 'transportation', name: 'transportation' },
                { data: 'floor', name: 'floor' },
                { data: 'floor_area', name: 'floor_area' },
                { data: 'height', name: 'height' },
                { data: 'air_con_system', name: 'air_con_system' },
                { data: 'lifts', name: 'lifts' },
                { data: 'parking', name: 'parking' },
                { data: 'carpark', name: 'carpark' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pageLength: 25,
            order: [[1, 'asc']]
        });
    });

    // Delete building via AJAX
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure you want to delete this building?')) {
            $.ajax({
                url: '/buildings/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#buildingTable').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
</script>
@endsection