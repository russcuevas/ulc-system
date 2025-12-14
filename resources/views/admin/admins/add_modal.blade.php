<div class="modal fade" id="addAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admins.store') }}" id="addAdminForm" class="needs-validation"
                novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Personal Info -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Personal Information</h6>
                            <div class="mb-3">
                                <label for="adminName" class="form-label">Full Name <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="text" class="form-control" name="fullname" required>

                                <div class="invalid-feedback">
                                    Please enter full name.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adminPhone" class="form-label">Phone <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="text" class="form-control" name="phone" required pattern="\d{11}"
                                    minlength="11" maxlength="11">

                                <div class="invalid-feedback">
                                    Please enter a valid phone number (11 digits required).
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Gender <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Male"
                                        checked>

                                    <label class="form-check-label" for="genderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Female">

                                    <label class="form-check-label" for="genderFemale">Female</label>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Account Info -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Account Information</h6>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">Email <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="email" class="form-control" name="email" required>

                                <div class="invalid-feedback">
                                    Please enter a valid email.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adminPassword" class="form-label">Password <span
                                        style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="password" class="form-control" id="adminPassword" name="password" required
                                    minlength="6">
                                <div class="invalid-feedback">
                                    Password must be at least 6 characters.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adminConfirmPassword" class="form-label">Confirm
                                    Password <span style="color: rgb(126, 30, 30)">*</span></label>
                                <input type="password" class="form-control" id="adminConfirmPassword"
                                    name="password_confirmation" required>
                                <div class="invalid-feedback" id="confirmPasswordFeedback">
                                    Passwords do not match.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addAdminSubmitBtn">
                        <span class="btn-text">Save</span>
                        <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
