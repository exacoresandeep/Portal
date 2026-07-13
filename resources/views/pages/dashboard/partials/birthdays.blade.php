<!-- Birthdays -->
<div class="col-lg-3 g-3">
    <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Birthdays Of The Month</h5>
        </div>

        <div class="card-body p-0">

            @forelse($birthdays as $employee)
                <div class="d-flex align-items-center px-3 py-2 border-bottom">

                    <img src="{{ $employee->photo
                            ? asset('storage/employees/'.$employee->photo)
                            : asset('assets/images/avatar.png') }}"
                        class="rounded-circle me-3"
                        width="45"
                        height="45">

                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            {{ $employee->name }}
                        </div>

                        <small class="text-muted">
                            {{ $employee->designation->name ?? '-' }}
                        </small>
                    </div>

                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') }}
                    </small>

                </div>
            @empty

                <div class="text-center py-5 text-muted">
                    No Birthdays
                </div>

            @endforelse

        </div>
    </div>
</div>