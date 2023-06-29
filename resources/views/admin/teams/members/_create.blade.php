<form method="post" class="card" action="{{ route('admin.teams.members.store', $team) }}">
    @csrf
    <div class="card-title">New Member</div>
    <div class="card-body">
        <x-form.select label="Select New Member" name="member" :options="$newMemberOptions" />
    </div>
    <div class="mt-3 card-footer">
        <button type="submit" class="btn btn-primary">
            Add Member
        </button>
    </div>
</form>
