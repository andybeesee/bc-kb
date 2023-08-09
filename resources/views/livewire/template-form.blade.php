<div>
    <div class="grid gap-4">
        <x-form.select wire:model.live="type" :options="['project' => 'Project', 'task_group' => 'Task Group']" name="type" label="Type" />

        @if($type === 'project')
            <livewire:template.project-form :save-redirect="true" />
        @else
            <livewire:template.task-group-form :save-redirect="true" />
        @endif
    </div>
</div>
