<div class="container-fluid">
    @include('pages.dashboard.partials.summary-cards')
    <div class="container-fluid mt-2">
        <div class="row">
            @include('pages.dashboard.partials.task-status')
            @include('pages.dashboard.partials.employee-distribution')
        </div>
        
        <div class="row">
            @include('pages.dashboard.partials.onboarding-chart')
            @include('pages.dashboard.partials.attendance-chart')
        </div>
        
        <div class="row">
            @include('pages.dashboard.partials.my-tasks')
            @include('pages.dashboard.partials.birthdays')
        </div>
    </div>
</div>
