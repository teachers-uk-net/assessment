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
