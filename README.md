# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - import the dbdump.sql in the "phptest" database
  - put your MySQL server credentials in the constructor of DB class
  - you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

  - easier to work with
  - more maintainable



#  Key Improvements:
Security Enhancements:

### Prepared Statements: 
Ensured that addCommentForNews and deleteComment methods use prepared statements to prevent SQL injection.

### Input Sanitization: 
Used htmlspecialchars to sanitize the body input in addCommentForNews to prevent XSS attacks.

### Type Casting: 
Cast newsId and id to integers to ensure they are of the correct type and prevent injection via these parameters.

### Comments: 
Added comments to explain the purpose of each function and key code blocks.

### Singleton Pattern: 
Simplified the getInstance method.

### Variable Naming: 
Used more descriptive variable names for clarity.

### Consistent Formatting: 
Ensured consistent indentation and spacing for better readability.

### Optimized List Retrieval:
array_map: Replaced the foreach loop with array_map to transform the rows into Comment objects.

## Notes:
Sanitization: The htmlspecialchars function is used to sanitize user inputs to prevent XSS attacks by escaping special characters in the body input.
Prepared Statements: Ensure your DB::exec method supports parameterized queries as demonstrated.
Type Casting: Casting newsId and id to (int) ensures they are integers, adding an extra layer of security.

