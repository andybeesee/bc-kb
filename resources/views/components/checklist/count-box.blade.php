@props(['checklist'])

<div class="grid grid-cols-4 divide-x text-xs">
    <span
        class="truncate bg-emerald-100 dark:bg-emerald-800 text-center {{ $checklist->complete_tasks_count === 0 ? 'text-green-100 dark:text-green-600' : '' }}"
        title="{{ $checklist->complete_tasks_count }} Completed Tasks"
    >
        {{ $checklist->complete_tasks_count }}
    </span>
    <span
        class="truncate bg-zinc-100 dark:bg-zinc-700 text-center {{ $checklist->incomplete_tasks_count === 0 ? 'text-zinc-100 dark:text-zinc-500' : '' }}"
        title="{{ $checklist->incomplete_tasks_count }} Incomplete Tasks"
    >
        {{ $checklist->incomplete_tasks_count }}
    </span>
    <span class="truncate {{ $checklist->incomplete_assigned_to_user_tasks_count > 0 ? 'bg-blue-100 dark:bg-blue-800' : 'bg-zinc-50 dark:bg-zinc-900' }} text-center" title="{{ $checklist->incomplete_assigned_to_user_tasks_count }} Incomplete Tasks Assigned to You">
        {{ $checklist->incomplete_assigned_to_user_tasks_count }}
    </span>
    <span class="truncate bg-red-100 dark:bg-red-800 text-center">
        {{ $checklist->late_tasks_count }}
    </span>
</div>
