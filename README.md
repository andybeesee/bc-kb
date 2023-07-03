We're going to have 

* Projects
  * which may have many boards
  * has a due date
  * has an owner
  * has a status
  * complete/incomplete
  * has files
  * has discussion
* Boards
  * may contain tasks
  * has a due date
  * has a status
  * has an owner
  * complete/incomplete
  * has files
  * has discussion
* Task
  * has an owner
  * has a due date
  * has a status
  * complete/incomplete
  * has comments ( list of words, not a discussion board)
* Project Templates
* Board Templates

# MVP
* user dashboard
  * currently assigned, incomplete tasks
  * links to team dashboards
  * currently 'owned' projects
* Teams
  * ~~CRUD~~
  * Team dashboards
* Projects
  * CRUD
    * add team/owner stuff
  * Start date/due date?
  * 'Last Update' field
  * Easy status update button
* Boards
  * CRUD
  * Dashboard (boards.index) - all boards with open tasks?
  * Move boards between projects
  * Files/comments?
  * 'last update' field?
* Tasks
  * CRUD
  * complete/due date/start date
  * Dashboard (tasks.index) - all tasks
  * move tasks between boards
  * assign
  * complete
* Files?
  * we have upload working on tasks, need to display and allow for download
  * 
* Comments?
  * everywhere? just on tasks? 
* Global status options & colors
  * do we weant statuses to filter down through boards and tasks? Or just on projects?

# MVP.2
* project/board templates
  * CRUD
* Project - create from template
* Track status changes (across proejct/task/all that jazz)
* Project/Board create - add from template
* Board/Tasks - import tasks from a template

# MVP.3
* per project status options
  * pulled from template OR team default
  * colors on status

# Page design

## Projects - its all DEEP LINKED
or we don't deep link a GD thing - and we just SPA the bad boy with a bunch of random components
with livewire instead of an actual SPA though
that seems straight forwad, no?

then we get rid of all those routes for files, and maybe some of the tasks? 

/projects
/projects/create
/projects/{project}
/projects/{project}/edit
/projects/{project}/files
/projects/{project}/files/create
/projects/{project}/files/{file}
/projects/{project}/files/{file}/edit
/projects/{project}/boards (sorting happens here too)
/projects/{project}/boards/create
/projects/{project}/boards/{board} (if part of a projects that is shown, tasks and files are shown on this page too)
/projects/{project}/boards/{board}/edit
/projects/{project}/boards/{board}/files
/projects/{project}/boards/{board}/files/create
/projects/{project}/boards/{board}/files/{file}
/projects/{project}/boards/{board}/files/{file}/edit
/projects/{project}/boards/{board}/tasks (sorting happens here too)
/projects/{project}/boards/{board}/tasks
/projects/{project}/boards/{board}/tasks/create
/projects/{project}/boards/{board}/tasks/{task|
/projects/{project}/boards/{board}/tasks/{task}/edit
/projects/{project}/boards/{board}/tasks/{task}/files
/projects/{project}/boards/{board}/tasks/{task}/files/create
/projects/{project}/boards/{board}/tasks/{task}/files/{file}
/projects/{project}/boards/{board}/tasks/{task}/files/{file}/edit

I think we'll also want some 'share' links that direct to an itesm deeply linked page

/tasks/{task}
/files/{file}
/boards/{board}
