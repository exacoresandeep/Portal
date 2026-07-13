<!-- Anniversaries -->
<div class="col-lg-3 g-3">
    <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Work Anniversary</h5>
        </div>

        <div class="card-body p-0">

            @forelse($anniversaries as $employee)

                @php
                    $years = \Carbon\Carbon::parse($employee->joining_date)->age;
                @endphp

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

                    <div class="text-end">

                        <div class="fw-bold text-primary">
                            {{ $years }}
                        </div>

                        <small class="text-muted">
                            Years
                        </small>

                    </div>

                </div>

            @empty

                <div class="text-center py-5 text-muted">
                    No Anniversaries
                </div>

            @endforelse

        </div>
    </div>
</div>