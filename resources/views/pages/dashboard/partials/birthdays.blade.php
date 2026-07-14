<!-- Birthdays  & anniversary-->
<div class="col-lg-4 g-3">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Birthdays Of The Month</h5>
        </div>

        <div class="card-body p-0">

            @forelse($birthdays as $employee)
                <div class="d-flex align-items-center px-3 py-2 border-bottom">

                    <img src="{{ $employee->photo
                            ? asset('storage/employees/photos/'.$employee->photo)
                            : asset('assets/img/avatar.png') }}"
                        class="rounded-circle me-3"
                        width="45"
                        height="45">

                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            {{ $employee->name }}
                        </div>

                        <small class="text-muted" style="font-size:11px;">
                            {{ $employee->designation->name ?? '-' }}
                        </small>
                    </div>

                    <small class="text-muted" >
                        {{ \Carbon\Carbon::parse($employee->dob)->year(now()->year)->format('d M Y') }}
                    </small>

                </div>
            @empty

                <div class="text-center py-5 text-muted">
                    No Birthdays
                </div>

            @endforelse

        </div>
    </div>
     <div class="card shadow-sm">
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
                             ? asset('storage/employees/photos/'.$employee->photo)
                            : asset('assets/img/avatar.png') }}"
                        class="rounded-circle me-3"
                        width="45"
                        height="45">

                    <div class="flex-grow-1">

                        <div class="fw-semibold">
                            {{ $employee->name }}
                        </div>

                        <small class="text-muted" style="font-size:11px;">
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