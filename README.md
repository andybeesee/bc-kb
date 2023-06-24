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

## Projects
/projects
/projects/create
/projects/{project}
/projects/{project}/edit
/projects/{project}/boards
/projects/{project}/files
/projects/{project}/files/create
/projects/{project}/files/{file}
/projects/{project}/files/{file}/edit

## Boards
/boards
/boards/create
/boards/{board} (if part of a projects that is shown, tasks and files are shown on this page too)
/boards/{board}/projects
/boards/{board}/edit
/boards/{boards}/tasks
/boards/{boards}/files
/boards/{boards}/files/create
/boards/{boards}/files/{file}
/boards/{boards}/files/{file}/edit

## Tasks
/tasks
/tasks/create
/tasks/{task|
/tasks/{task}/edit
/tasks/{task}/files
/tasks/{task}/files/create
/tasks/{task}/files/{file}
/tasks/{task}/files/{file}/edit
