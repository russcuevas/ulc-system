<div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1"
    aria-labelledby="editClientModalLabel{{ $client->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel{{ $client->id }}">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Personal Info -->
                        <div class="col-md-12">

                            <div class="mb-3">
                                <label class="form-label">Full Name <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="text" class="form-control" name="fullname"
                                    value="{{ $client->fullname }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone <span style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="text" class="form-control" name="phone" value="{{ $client->phone }}"
                                    required pattern="\d{11}" minlength="11" maxlength="11">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address <span style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="text" class="form-control" name="address" value="{{ $client->address }}"
                                    required>
                            </div>

                            <div class="row">
                                <div class="col-lg-5 mb-3">
                                    <label class="form-label">Select Area <span
                                            style="color: rgb(126, 30, 30)">*</span></label>
                                    <select class="form-control select-form select2" name="area_id" required>
                                        <option value="" disabled>Select Area</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ $client->area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->area_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-7 mb-3">
                                    <label class="form-label d-block">Gender <span
                                            style="color: rgb(126, 30, 30)">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Male"
                                            {{ $client->gender == 'Male' ? 'checked' : '' }}>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Female"
                                            {{ $client->gender == 'Female' ? 'checked' : '' }}>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
