We're going to have

* Project boards/lanes
  * task list on projects - simpler re-use of task lists that way I think
  * and it narrows down the page depth on projects
  * team based board list helps
    * replicates my Excel structure upcoming, this year, in progress, etc.
    * each team can have their own boards
  * project (may belong to many boards and teams)
  * task - belogns to project (project has many tasks)
  * project task list has titles in them for sorting (easier than separate board object)
    * mostly for organizational purposes - collapse/expand and whatnot

CLEANED UP VERSION

* Team
  * has many members
  * has many projects
* User
  * belongs to many teams
  * assigned to many projects
  * assigned to many tasks
* Project
  * has many task groups
  * has many tasks
  * has many files ** not implemented
  * comments/discussion? ** not implemented
* Task
  * belongs to a project
  * may belong to a task group
  * may be assigned
  * may be completed
  * has many files
  * due date
  * status
  * comments/discussion *** not implemented
* Task group
  * belongs to a project
  * may have many tasks
  * may be assigned? *** not implemented, do we want this?
  * files?
  * comments/discussion?
* Project Templates ** TODO
* Board Templates ** TODO

# MVP
* user dashboard
  * ~~currently assigned tasks~~
  * ~~incomplete tasks~~
  * links to team dashboards
  * ~~late tasks~~
  * ~~currently 'owned' projects~~
* Teams
  * ~~CRUD~~
  * Team dashboards
* Projects
  * CRUD
    * ~~add team/owner stuff~~ in the create/edit form
    * ~~Start date/due date?~~ in the create/edit form
  * 'Last Update' field
    * not sure how I want this - but I want it to be easy to see the last progress made and if there are blockers on it
  * Easy status update button
    * this is in the create/edit form - it should be easier though
* Tasks
  * CRUD
  * Dashboard (tasks.index) - all tasks
  * Change due date inline
  * ~~move tasks between groups~~
  * ~~assign~~
  * ~~complete~~
* Files?
  * we have upload working on tasks, need to display and allow for download
  * this should be similar to comments/discussion boards
    * maybe on file we'll do a weird simple thing and just hav eall columns
      * project_id, task_id, task_group_id, discussion_board_id, comment_id?
      * this is an annoying thing to do - but it makes the querying a lot easier?
* Comments?
  * everywhere? just on tasks? 
  * If we re-frame this as 'discussion boards' I think it is better
  * Every discussion board can be attached to some things - project/task/task group/team
    * then visiting the project you can see all boards, and also a note that the discussion is about task 1234
* Global status options & colors
  * do we weant statuses to filter down through boards and tasks? Or just on projects?

# MVP.2
* project/board templates
  * CRUD
* Project - create from template
* Track status changes (across proejct/task/all that jazz)
* Project/Board create - add from template
* Board/Tasks - import tasks from a template
* Tasks
  * modify complete date
  * modify who completed a task
  * add a start date

# MVP.3
* per project status options
  * pulled from template OR team default
  * colors on status
* task/group dependencies - can't start until other item is completed
  * due date is dependent on completion of other item (eg due x days after item 'z' is completed)
* template relative due date
  * in template 'x days' after start date on project

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
