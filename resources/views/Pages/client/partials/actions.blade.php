<div class="d-inline-flex">
    <div class="dropdown">
        <a href="#" class="text-body" data-bs-toggle="dropdown"><i class="ph-list"></i></a>
        <div class="dropdown-menu dropdown-menu-end">
            @can('edit_customer')
                <a href="{{ route('client.edit', $id) }}" class="dropdown-item">
                    <i class="ph-pencil-line me-2"></i>Edit
                </a>
            @endcan
            @can('delete_customer')
                <form action="{{ route('client.delete', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this Client?');">
                        <i class="ph-trash me-2"></i>Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>