<div class="col-lg-6 g-3">
    <div class="card shadow-sm rounded-4 h-100">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Employee Onboarding By Year</h6>

            <select class="form-select form-select-sm w-auto" id="onboardingYear">
                @for($year = date('Y'); $year >= 2020; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div class="card-body">
            <div style="height:300px;">
                <canvas id="onboardingChart"></canvas>
            </div>
        </div>

    </div>
</div>