# Simple-PHP-MVC
Simple MVC template in PHP

Simple-PHP-MVC is an educational project that can help new programmers to understand how MVC can work in OOP PHP programming.
Useful folders are:

application/controllers/ - contains all controller classes, that extends from Application\Base\Base_Controller() class.

application/models/ - contains all models classes, that extends drom Application\Base\Base_Model() class. In Base_Model() there are some CRUD predefined method for database management.

application/views/ - contains all views files. In subdirectory /templates/ there is a default template example.

application/helpers/ - contains useful static classes to manage Logs and Views.

application/core/ - contains global scripts included in ../index.php like spl_autoload() function and global constants declarations.

More documentation will come with newer updates!
Feel free to e-mail me to chris.baviera@gmail.com for suggestion and collaborate if you want to!
