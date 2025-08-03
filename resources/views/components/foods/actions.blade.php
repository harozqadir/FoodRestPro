<a href="{{ $editUrl }}" class="btn btn-sm btn-primary">Edit</a>

<form action="{{ $deleteUrl }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
        Delete
    </button>
</form>
