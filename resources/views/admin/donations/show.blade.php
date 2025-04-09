@extends('admin.layout')

@section('title', 'Donation Details')

@section('page-title', 'Donation Details')

@section('styles')
<style>
    body {
        background-color: #f5f7fb;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    
    .card-header {
        background-color: white;
        border-bottom: 1px solid #edf2f9;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 16px;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }
    
    .card-header i {
        color: #3b7ddd;
        margin-right: 10px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .amount-card {
        background: linear-gradient(45deg, #3b7ddd, #6196e4);
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .amount-card .card-body {
        position: relative;
        z-index: 1;
    }
    
    .amount-card::before {
        content: "";
        position: absolute;
        right: -40px;
        bottom: -50px;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .amount-card::after {
        content: "";
        position: absolute;
        right: 40px;
        top: -50px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .amount-label {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-bottom: 10px;
    }
    
    .amount-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .amount-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.9rem;
    }
    
    .amount-meta-item {
        display: flex;
        align-items: center;
    }
    
    .amount-meta-item i {
        margin-right: 5px;
        opacity: 0.8;
    }
    
    .info-table {
        width: 100%;
    }
    
    .info-table td {
        padding: 12px 5px;
        border-bottom: 1px solid #edf2f9;
    }
    
    .info-table tr:last-child td {
        border-bottom: none;
    }
    
    .info-label {
        color: #6c757d;
        font-weight: 500;
        width: 140px;
    }
    
    .badge-outline {
        background-color: transparent;
        border: 1px solid;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    
    .badge-outline.primary {
        color: #3b7ddd;
        border-color: #3b7ddd;
        background-color: rgba(59, 125, 221, 0.1);
    }
    
    .badge-outline.success {
        color: #28a745;
        border-color: #28a745;
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .badge-outline.warning {
        color: #ffc107;
        border-color: #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .badge-outline.danger {
        color: #dc3545;
        border-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .badge-outline i {
        margin-right: 5px;
    }
    
    .donor-info {
        display: flex;
        align-items: center;
    }
    
    .donor-avatar {
        width: 50px;
        height: 50px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #6c757d;
    }
    
    .donor-name {
        font-weight: 600;
        margin-bottom: 3px;
    }
    
    .donor-email {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background-color: #edf2f9;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 0;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #3b7ddd;
        border: 3px solid white;
    }
    
    .timeline-content {
        padding-bottom: 10px;
    }
    
    .timeline-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .activity-header {
        position: relative;
        height: 120px;
        background-size: cover;
        background-position: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .activity-header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .activity-title {
        color: white;
        font-weight: 600;
        text-align: center;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        padding: 0 20px;
    }
    
    .activity-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 5px;
    }
    
    .activity-meta {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #edf2f9;
        margin-bottom: 15px;
    }
    
    .activity-meta-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .activity-meta-label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .activity-meta-value {
        font-weight: 600;
    }
    
    .activity-progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .activity-progress-label {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .activity-progress-percent {
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .activity-progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #edf2f9;
        margin-bottom: 15px;
    }
    
    .activity-progress-value {
        height: 100%;
        border-radius: 4px;
        background-color: #28a745;
    }
    
    .activity-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    .related-donation {
        padding: 12px 15px;
        border-radius: 5px;
        background-color: #f8f9fa;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }
    
    .related-donation:hover {
        background-color: #e9ecef;
        transform: translateX(5px);
    }
    
    .related-donation:last-child {
        margin-bottom: 0;
    }
    
    .related-amount {
        font-weight: 700;
        color: #3b7ddd;
        margin-right: 15px;
        min-width: 80px;
    }
    
    .related-info {
        flex: 1;
    }
    
    .related-label {
        font-size: 0.85rem;
        margin-bottom: 2px;
    }
    
    .related-date {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .related-icon {
        margin-left: 10px;
        color: #6c757d;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        color: #495057;
        text-decoration: none;
        margin-bottom: 20px;
        transition: all 0.2s ease;
    }
    
    .back-button:hover {
        background-color: #f8f9fa;
        transform: translateX(-5px);
    }
    
    .back-button i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Back Button -->
    <a href="{{ route('donations.index') }}" class="back-button btn btn-secondary ms-2 action-btn">
       Back to Donations  <i class="fas fa-arrow-left"></i>
    </a>

    <h1 class="page-title">Donation Details</h1>
    
    <div class="row">
        <!-- Donation Amount Card -->
        <div class="col-lg-6">
            <div class="card amount-card">
                <div class="card-body">
                    <div class="amount-label">DONATION AMOUNT</div>
                    <div class="amount-value">{{ number_format($donation->amount, 2) }} SR</div>
                    <div class="amount-meta">
                        <div class="amount-meta-item">
                            <i class="fas fa-hashtag"></i>
                            <span>ID: {{ $donation->id }}</span>
                        </div>
                        <div class="amount-meta-item">
                            <i class="far fa-calendar-alt"></i>
                            <span>
                                @if($donation->donated_at instanceof \DateTime) 
                                    {{ $donation->donated_at->format('F j, Y') }}
                                @elseif(is_string($donation->donated_at) && !empty($donation->donated_at))
                                    {{ date('F j, Y', strtotime($donation->donated_at)) }}
                                @else
                                    {{ $donation->created_at->format('F j, Y') }}
                                @endif
                            </span>
                        </div>
                        @if($donation->transaction_id)
                        <div class="amount-meta-item">
                            <i class="fas fa-receipt"></i>
                            <span>{{ $donation->transaction_id }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Donor Information Card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> Donor Information
                </div>
                <div class="card-body">
                    <div class="donor-info">
                        <div class="donor-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="donor-name">{{ $donation->user->full_name ?? 'Unknown Donor' }}</div>
                            @if($donation->user && isset($donation->user->email))
                                <div class="donor-email">{{ $donation->user->email }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Payment Details Card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-credit-card"></i> Payment Details
                </div>
                <div class="card-body">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Payment Method</td>
                            <td>
                                @if($donation->payment_method == 'credit_card')
                                    <span class="badge-outline primary">
                                        <i class="far fa-credit-card"></i> Credit Card
                                    </span>
                                @elseif($donation->payment_method == 'bank_transfer')
                                    <span class="badge-outline primary">
                                        <i class="fas fa-university"></i> Bank Transfer
                                    </span>
                                @elseif($donation->payment_method == 'cash')
                                    <span class="badge-outline success">
                                        <i class="fas fa-money-bill-wave"></i> Cash
                                    </span>
                                @else
                                    <span class="badge-outline primary">
                                        <i class="fas fa-money-bill-alt"></i> {{ $donation->payment_method ?? 'Other' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Transaction ID</td>
                            <td>{{ $donation->transaction_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Donation Date</td>
                            <td>
                                @if($donation->donated_at instanceof \DateTime) 
                                    {{ $donation->donated_at->format('F j, Y g:i A') }}
                                @elseif(is_string($donation->donated_at) && !empty($donation->donated_at))
                                    {{ date('F j, Y g:i A', strtotime($donation->donated_at)) }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @if($donation->notes)
                        <tr>
                            <td class="info-label">Notes</td>
                            <td>
                                <div class="p-2 bg-light rounded">
                                    {{ $donation->notes }}
                                </div>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            <!-- Timeline Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history"></i> Timeline
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Donation Recorded</div>
                                <div class="timeline-date">
                                    @if($donation->created_at instanceof \DateTime)
                                        {{ $donation->created_at->format('F j, Y g:i A') }}
                                    @else
                                        {{ date('F j, Y g:i A', strtotime($donation->created_at)) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($donation->donated_at && $donation->created_at &&
    ((is_object($donation->donated_at) && $donation->donated_at->format('Y-m-d H:i:s') != $donation->created_at->format('Y-m-d H:i:s')) ||
     (is_string($donation->donated_at) && date('Y-m-d H:i:s', strtotime($donation->donated_at)) != $donation->created_at->format('Y-m-d H:i:s'))))

                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Donation Date</div>
                                <div class="timeline-date">
                                    @if($donation->donated_at instanceof \DateTime)
                                        {{ $donation->donated_at->format('F j, Y g:i A') }}
                                    @elseif(is_string($donation->donated_at))
                                        {{ date('F j, Y g:i A', strtotime($donation->donated_at)) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(is_object($donation->updated_at) && $donation->updated_at->format('Y-m-d H:i:s') != $donation->created_at->format('Y-m-d H:i:s'))
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Last Updated</div>
                                <div class="timeline-date">{{ $donation->updated_at->format('F j, Y g:i A') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <!-- Activity Information Card -->
            @if($donation->activity)
            <div class="card">
                <div class="activity-header" style="background-image: url('{{ $donation->activity->image ? asset('storage/'.$donation->activity->image) : asset('images/default-activity.jpg') }}')">
                    <div class="activity-header-overlay">
                        <h4 class="activity-title">{{ $donation->activity->title }}</h4>
                    </div>
                    @if(isset($donation->activity->status))
                    <div class="activity-badge 
                        @if($donation->activity->status == 'upcoming') 
                            bg-warning
                        @elseif($donation->activity->status == 'completed' || $donation->activity->status == 'done')
                            bg-success
                        @else
                            bg-danger
                        @endif">
                        {{ ucfirst($donation->activity->status) }}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="activity-meta">
                        <div class="activity-meta-item">
                            <div class="activity-meta-label">DATE</div>
                            <div class="activity-meta-value">
                                @if(isset($donation->activity->date) && $donation->activity->date instanceof \DateTime)
                                    {{ $donation->activity->date->format('M d, Y') }}
                                @elseif(isset($donation->activity->date) && is_string($donation->activity->date))
                                    {{ date('M d, Y', strtotime($donation->activity->date)) }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        
                        <div class="activity-meta-item">
                            <div class="activity-meta-label">DONORS</div>
                            <div class="activity-meta-value">{{ $donation->activity->donations_count ?? '0' }}</div>
                        </div>
                        
                        @if(isset($donation->activity->donation_goal) && $donation->activity->donation_goal)
                        <div class="activity-meta-item">
                            <div class="activity-meta-label">GOAL</div>
                            <div class="activity-meta-value">{{ number_format($donation->activity->donation_goal) }} SR</div>
                        </div>
                        @endif
                    </div>
                    
                    @if(isset($donation->activity->donation_goal) && $donation->activity->donation_goal)
                    <div class="activity-progress-header">
                        <div class="activity-progress-label">Progress</div>
                        <div class="activity-progress-percent">
                            {{ number_format(($donation->activity->total_donations / $donation->activity->donation_goal) * 100, 0) }}%
                        </div>
                    </div>
                    <div class="activity-progress-bar">
                        <div class="activity-progress-value" style="width: {{ min(($donation->activity->total_donations / $donation->activity->donation_goal) * 100, 100) }}%"></div>
                    </div>
                    @endif
                    
                    <p class="activity-description">{{ Str::limit($donation->activity->description ?? 'No description available', 150) }}</p>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt"></i> Activity Information
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 48px;"></i>
                    <h5>No Activity Information</h5>
                    <p class="text-muted">This donation is not associated with any activity or the activity has been deleted.</p>
                </div>
            </div>
            @endif
            
            <!-- Related Donations Card -->
            @if($relatedDonations && $relatedDonations->count() > 0)
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-link"></i> Related Donations
                </div>
                <div class="card-body">
                    @foreach($relatedDonations as $relatedDonation)
                    <a href="{{ route('donations.show', $relatedDonation) }}" class="related-donation">
                        <div class="related-amount">{{ number_format($relatedDonation->amount, 2) }} SR</div>
                        <div class="related-info">
                            <div class="related-label">
                                @if($relatedDonation->user_id == $donation->user_id)
                                    <i class="fas fa-user me-1"></i> Same donor
                                @else
                                    <i class="fas fa-calendar-alt me-1"></i> Same activity
                                @endif
                            </div>
                            <div class="related-date">
                                @if($relatedDonation->created_at instanceof \DateTime)
                                    {{ $relatedDonation->created_at->format('M d, Y') }}
                                @else
                                    {{ date('M d, Y', strtotime($relatedDonation->created_at)) }}
                                @endif
                            </div>
                        </div>
                        <div class="related-icon">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection