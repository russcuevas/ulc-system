<div class="modal fade" id="updateAdminModal{{ $admin->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admins.update', $admin->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">

                        <!-- LEFT -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Personal Information</h6>

                            <div class="mb-3">
                                <label for="updateFullname" class="form-label">Full Name</label>
                                <input id="updateFullname" type="text" class="form-control" name="fullname"
                                    value="{{ $admin->fullname }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="updatePhone" class="form-label">Phone</label>
                                <input id="updatePhone" type="text" class="form-control" name="phone"
                                    value="{{ $admin->phone }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Gender</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Male"
                                        {{ $admin->gender == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Female"
                                        {{ $admin->gender == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label">Female</label>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Account Information</h6>

                            <div class="mb-3">
                                <label for="updateEmail" class="form-label">Email</label>
                                <input type="email" id="updateEmail" class="form-control" name="email"
                                    value="{{ $admin->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="updatePassword" class="form-label">New Password
                                    (optional)
                                </label>
                                <input id="updatePassword" type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="updateConfirmPassword" class="form-label">Confirm
                                    Password</label>
                                <input id="updateConfirmPassword" type="password" class="form-control"
                                    name="password_confirmation">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>


            </form>
        </div>
    </div>
</div>
