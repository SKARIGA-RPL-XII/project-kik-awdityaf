<div class="row">

    <!-- LEFT -->
    <div class="col-md-8">

        <h4 class="text-success">
            {{ $plan->plan_name }}
        </h4>

        <p class="text-muted">
            {{ $plan->description }}
        </p>


        <div class="row mb-3">

            <div class="col-md-6">

                <h6>Duration</h6>

                <p>
                    {{ $plan->duration_months }}
                    Month{{ $plan->duration_months > 1 ? 's' : '' }}
                </p>

            </div>


            <div class="col-md-6">

                <h6>Price</h6>

                <h4 class="text-success">
                    Rp {{ number_format($plan->price, 0, ',', '.') }}
                </h4>

                <small class="text-muted">

                    Rp {{ number_format($plan->price / $plan->duration_months, 0, ',', '.') }}
                    per month

                </small>

            </div>

        </div>


        {{-- FEATURES --}}
        @if(!empty($plan->features))

        <h6>Features</h6>

        <ul class="list-unstyled">

            @foreach(explode(',', $plan->features) as $feature)

            @if(trim($feature))

            <li>
                <i class="fas fa-check text-success mr-2"></i>
                {{ trim($feature) }}
            </li>

            @endif

            @endforeach

        </ul>

        @endif

    </div>



    <!-- RIGHT -->
    <div class="col-md-4">


        <!-- STATUS -->
        <div class="card border-success">

            <div class="card-header bg-success text-white text-center">
                <h6 class="m-0">Plan Status</h6>
            </div>


            <div class="card-body text-center">

                @if($plan->is_active)

                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>

                <h6 class="text-success">Active</h6>

                <p class="text-muted">
                    This plan is available for new subscriptions
                </p>

                @else

                <i class="fas fa-pause-circle fa-3x text-warning mb-2"></i>

                <h6 class="text-warning">Inactive</h6>

                <p class="text-muted">
                    This plan is not available for new subscriptions
                </p>

                @endif

            </div>

        </div>



        <!-- INFO -->
        <div class="mt-3">

            <h6>Plan Information</h6>

            <table class="table table-borderless table-sm">

                <tr>
                    <td><strong>Created:</strong></td>
                    <td>{{ $plan->created_at->format('M d, Y') }}</td>
                </tr>

                <tr>
                    <td><strong>Updated:</strong></td>
                    <td>{{ $plan->updated_at->format('M d, Y') }}</td>
                </tr>

                <tr>
                    <td><strong>Duration:</strong></td>
                    <td>{{ $plan->duration_months }} months</td>
                </tr>

                <tr>
                    <td><strong>Price/Month:</strong></td>

                    <td>
                        Rp {{ number_format($plan->price / $plan->duration_months, 0, ',', '.') }}
                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>



<hr>



<!-- STATISTICS -->
<div class="row">

    <div class="col-12">

        <h6>Plan Statistics</h6>


        <div class="row">


            <!-- SUBSCRIBERS -->
            <div class="col-md-3">

                <div class="card border-left-primary">

                    <div class="card-body">

                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Subscribers
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalSubscribers ?? 0 }}
                        </div>

                    </div>

                </div>

            </div>



            <!-- REVENUE -->
            <div class="col-md-3">

                <div class="card border-left-success">

                    <div class="card-body">

                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

            </div>



            <!-- ACTIVE -->
            <div class="col-md-3">

                <div class="card border-left-info">

                    <div class="card-body">

                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Active Subscriptions
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $activeSubscriptions ?? 0 }}
                        </div>

                    </div>

                </div>

            </div>



            <!-- AVG -->
            <div class="col-md-3">

                <div class="card border-left-warning">

                    <div class="card-body">

                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Avg. Duration
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $plan->duration_months }}m
                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>