<span class="grid grid-cols-4 items-center text-xs gap-0 max-w-[75px] min-w-[75px]">
    <span title="All Incomplete tasks" class="border text-center truncate {{ $board->incomplete_tasks_count > 0 ? 'bg-zinc-600 text-white' : '' }}">
        {{ $board->incomplete_tasks_count }}

    </span>
    <span title="Past Due Tasks" class="border text-center truncate {{ $board->past_due_tasks_count > 0 ? 'bg-red-600 text-white' : '' }}">
        {{ $board->past_due_tasks_count }}
    </span>
    <span title="Your incomplete tasks" class="border text-center truncate {{ $board->incomplete_user_tasks_count > 0 ? 'bg-blue-600 text-white' : '' }}">
        {{ $board->incomplete_user_tasks_count }}
    </span>
</span>
