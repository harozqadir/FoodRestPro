@props(['chehckedifupdate'])

<button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
    <i class="fas fa-save me-2"></i>
    {{ $chehckedifupdate ? 'Update ' : 'Create ' }}
</button>
