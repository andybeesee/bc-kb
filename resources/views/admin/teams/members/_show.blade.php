<div class="flex items-center hover:bg-zinc-50 p-2">
    {{ $member->name }}

    <form class="ml-auto" action="{{ route('admin.teams.members.destroy', [$team, $member]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-sm btn btn-danger">Remove</button>
    </form>
</div>
