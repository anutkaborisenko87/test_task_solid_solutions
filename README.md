## About this project

The application displays arbitrary "trees" of text nodes and provides the user with the ability to add new nodes (roots)
and remove existing ones.

Initially, only the "New root" button is shown on the page. When pressed, a modal window pops up with a form for
entering the name of the "root of the tree". The “root” has two buttons: “add node” (in the form of a button with a “+”
icon) and “delete node” (in the form of a button with a “-” icon). The new node, like any other new nodes, has the same
two buttons.

When you click on the “+”, a modal window appears with a form for entering the name of a new node, after submitting the
completed form, a new node is added, to the right and below, relative to the one next to which the button was pressed.
When you click on "-" - the node is deleted with all nested nodes.
The tree structure (child nodes) becomes visible when hovering over the "root" (respectively, child nodes become visible
when hovering over the parent node).

- Node data is stored in the database.

- All actions with deleting and adding nodes (roots) are performed without reloading the page (with each action, the
  data
  in the database is updated) and updating the structure on the page.

- When trying to delete a tree root, a confirmation popup appears. To the left of the buttons is a countdown timer (
  initially 20 seconds). When you press the "x", "No" buttons or when the timer becomes "0" - the window simply closes.
  When you click on "Yes" - the tree is deleted.

- When trying to delete a node, a confirmation modal pops up without a timer
- additionally added validation of the input fields for the name of the node (root) of the tree (required,
  the length from 5 to 15 characters)
- Bootstrap was used to design the page.

- The technologies used here are pure PHP (the MVC pattern is re-released) + JS (jQuery).

- database dump is
  here [script.sql](https://github.com/anutkaborisenko87/test_task_solid_solutions/blob/main/script.sql)

- added ability to edit node titles

  - when you click on the title of the node (root), a modal appears with the form for editing the title of the node (
  root), where validation also works

## Instructions for checking this project:

To check the functionality of the project, you need to clone the project:

```
git clone https://github.com/anutkaborisenko87/test_task_solid_solutions.git
```

enter the console command while in the root folder of the project

```
composer install 
```

- this command initializes autoload of classes and include of additional files that ensure the workability
  of the project
- create a database for the project
- export the script [script.sql](https://github.com/anutkaborisenko87/test_task_solid_solutions/blob/main/script.sql) to
  the created database (it will create the main project table)
- To set up a connection to the database, you need to enter the appropriate settings in the
  file [app/helpers/helpers.php](https://github.com/anutkaborisenko87/test_task_solid_solutions/blob/main/app/helpers/helpers.php)
  in
  method [config](https://github.com/anutkaborisenko87/test_task_solid_solutions/blob/main/app/helpers/helpers.php#L48)
  in array $config

### My github profile

Here you can see examples of my other work. Even though these are just test tasks, they can be used to understand my
approach to completing tasks.

- [Anna Borisenko](https://github.com/anutkaborisenko87/)

### Contacts

- **Linkedin: [Anna Borisenko](https://www.linkedin.com/in/anna-borisenko-695837213/)**
- **Telegram: [Anna Borisenko](https://t.me/AnutkaBorisenko)**
- **email: [anutkaborisenko87@gmail.com](anutkaborisenko87@gmail.com)**
