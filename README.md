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
