{{-- filepath: resources/views/components/restaurant-header.blade.php --}}
<div class="restaurant-header d-flex justify-content-between align-items-center mb-4" style="font-family: 'RudawRegular', sans-serif;">
    <div class="d-flex align-items-center" style="gap: 1rem;">
        <span class="icon bg-white text-primary shadow-sm">
            <i class="{{ $icon ?? 'fas fa-users' }}"></i>
        </span>
        <div>
            <h2 class="mb-1 fw-bold">{{ $title }}</h2>
            <div class="text-light small">{{ $subtitle }}</div>
        </div>
    </div>
    @if(isset($actionRoute) && isset($actionText))
        <a href="{{ $actionRoute }}" class="btn btn-success modern-btn shadow d-flex align-items-center px-4 py-2 fs-5" style="gap: 0.5rem; font-weight: 600;">
            <i class="{{ $actionIcon ?? 'fas fa-user-plus me-2 fs-4' }}"></i>
            <span>{{ $actionText }}</span>
        </a>
    @endif
</div>