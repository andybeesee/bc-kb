<span class="grid grid-cols-4 items-center text-xs gap-0 max-w-[75px] min-w-[75px]">
    <!--x-icon icon="grip-vertical" class="handle h-4 w-4 mr-1 cursor-move text-zinc-400 hover:text-zinc-600 dark:text-zinc-400 dark:hover:text-zinc-100" /-->
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
