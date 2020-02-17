# php-erp

## Project Purpose
To demonstrate your procedural skills, coding style and aptitude to our development team.

## Project Requirements
Create employee management pages for a fast food restaurant chain. The main page is an
employee listing page displaying the employee's name, store-location, and status
(active/inactive). The end user should be able to perform the following operations 
on employees from the listing page: 
- [x] add 
- [x] edit 
- [x] sort 
- [x] activate & de-activate

Your database should include locations but you will not be
required to create management pages for the chain&#39;s locations. This assignment should be
programmed using procedural PHP. Do not use a framework.

## Pages
- [x] Employee Listing (index.php) – This page will display all of the company&#39;s employees
in alphabetical order (last, first). The page should display the employee&#39;s name, store
location, and status. The end user should also be able to sort by each column
displayed with data.
*If you would like to use Ajax or jQuery, enable and disable the employee from this
page. Otherwise, see “Delete Employee” below.
- [x] Add Employee (add.php) – This page will allow the end user to add an employee
record. We will need to store the employee&#39;s name, store location, and status.
- [x] Edit Employee (edit.php) – This page will allow the end user to edit an employee&#39;s
record. We should be able to update the employee&#39;s name, store location, and status.
- [x] Delete Employee (delete.php) - This page will allow the end user to enable or disable
an employee.

## Page Layouts
Add, Edit, and “Delete&quot; Employee pages can be laid out however you feel necessary. The
Employee Listing page should be tabular. If using Ajax/jQuery, the first column should contain
a checkbox allowing the user to enable or disable the employee within the row. If not, use a
column to display the user&#39;s status.

### Example with Ajax/jQuery:
| Active | Employee Name    | Location      | Actions |
|--|--|--|--|
| ☐ | ~Mattern, Bryan~   | ~Atlanta, GA~   |  Edit \| Delete    |
| ☑ | Moghari, Jessica   | Marietta, GA    |  Edit \| Delete    |

### Example without Ajax/jQuery:
| Active   | Employee Name    | Location      | Actions        |
|--|--|--|--|
| Yes      | Mattern, Bryan   | Atlanta, GA   | Edit \| Delete |
| No       | Moghari, Jessica | Marietta, GA  | Edit \| Delete |


## Deliverables
Please deliver the final website, files and database schema. All
pages should be W3C compliant and pass through a HTML and CSS validator. The website
should use a HTML 4.01 Strict doctype.

Also provide a small report on your database schema and which security precautions you
took in your application.
