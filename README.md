# Assessment module

Allows fairly accurate re-creation of exams on html pages that can 
then store responses in MariaDB using php

Responses can be marked with direct feedback and mark for each 
question saved

### TODO

- Add a column (boolean) in tblGroupTests for 'marked'
- Create a view so that when 'marked' and 'Available' are true student 
sees a button to take them to feedback and marks
- Add a view in admin backend to toggle 'marked'
- Add dashboards to view students progress / results
- Re-write everything using PDO
- Add sql for tables to repo (with some "dummy" data perhaps)
- Add an example of an assessment upload csv file)

##### Known issues

It is not buggy but it is a little clunky!
Make sure group is made before adding users in to the group using csv upload (prefer not to put an 'if !exists' in because it stops typos inadvertantly creating unwanted groups)
Make sure test is created before uploading questions (same reason for not having 'if !exists')
The question types 1 to 4 are only valid for a simpler front end with only one question per page
For the more advanced (type 5) question format plan the assessment you want to deliver and put basic text in the question column then edit the questions using the web front end (where the ckeditor/ckfinder plug in lets you upload images to include in part of the question).
The CKEditor submodule points to a private repo (because CKEditor is not on Github) - recommend you get the latest version direct from CKEditor
Inside CKEditor, CKFinder (another submodule) is version 3.5.0 (tried 3.5.1+ and it did not play nicely with something)
