<div class="container-fluid">
    <h4>Clients in Area: {{ $area->area_name }}</h4>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->fullname }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($client->created_at)->format('F j, Y - h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>